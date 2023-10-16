'''


 Copyright (c) 2023 Jolly & Andreas <a.wiora@uq.net.au>

 Permission to use, copy, modify, and distribute this software for any
 purpose with or without fee is hereby granted, provided that the above
 copyright notice and this permission notice appear in all copies.

 THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
 WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
 MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR
 ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
 WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN
 ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF
 OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.


--------------------------------------------
  sensor pin |		 raspberry pi		   |
	  VCC  	 |			5V/3V3			   |
	  GND	 |			 GND			   |
	  RX	 |		  (BCM)14 TX		   |
	  TX	 |		  (BCM)15 RX		   |
--------------------------------------------
'''

import sys, os, time, datetime
import requests
import json

# add parent directory to path for a02 module
sys.path.append(os.path.dirname(os.path.dirname(os.path.realpath(__file__))))
from driver_a02yyuw import a02_distance as Board

board = Board()
lchars = ["-", "\\", "|", "/"]
# iter through lchars
n = 0

# handle time, date and device ID
def dtime(dev_id=0x001):
	# setup date and time
	today = datetime.date.today()
	current_time = datetime.datetime.now()
	timestr = current_time.strftime("%H:%M:%S")

	# hardcode device ID for now
	# convert to JSON format
	info = {
			"date": str(today),
			"time": str(timestr),
			"device_id": str(dev_id)
	}

	return json.dumps(info)

# handle sensor trigger
def sdistance(d):
	if board.last_operate_status == board.STA_OK:
		# debug
		#print("distance %d mm" %d)
		return d
	elif board.last_operate_status == board.STA_ERR_CHECKSUM:
		print("error: failed checksum")
	elif board.last_operate_status == board.STA_ERR_SERIAL:
		print("error: serial port open failed")
	elif board.last_operate_status == board.STA_ERR_CHECK_OUT_LIMIT:
		print("error: upper limit reached at %d" %d)
	elif board.last_operate_status == board.STA_ERR_CHECK_LOW_LIMIT:
		print("error: lower limit reached at %d" %d)
	elif board.last_operate_status == board.STA_ERR_DATA:
		print("error: no data")
	else:
		return -1

def send_info(data):
	url = "https://deco3801-lazycc.uqcloud.net/lazycc"

	# convert to dict
	data = json.loads(data)

	# send a post request
	err = requests.post(url, json=data)
	if err.status_code == 200:
		print(err.text)
		return 0
	else:
		return 1

### removed the code for this, it can be added it back later
def progress_bar():
    pass

if __name__ == "__main__":
	# lower limit set 0mm
	dis_min = 0
	# max limit set 4500mm
	dis_max = 4500
	board.set_dis_range(dis_min, dis_max)
	while True:
		# get live distance
		d = board.getDistance()

		# display simple animation while sensor is reading
		c = lchars[n % len(lchars)]
		sys.stdout.write(c + "\r")
		sys.stdout.flush()
		n += 1

		err = sdistance(d)
		if err == -1:
			sys.exit()
		if err <= 100:
			if (send_info(dtime())):
				print("error: send failed")
			# sleep before the next reading
			print("waiting ...")
			time.sleep(20)

		# set delay time < 0.6s < don't delay for more
		time.sleep(0.5)
