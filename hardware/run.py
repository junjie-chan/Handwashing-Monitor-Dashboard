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
import socket
import requests
import json

# add parent directory to path for a02 module
sys.path.append(os.path.dirname(os.path.dirname(os.path.realpath(__file__))))
from driver_a02yyuw import a02_distance as Board

endpoint = "https://deco3801-lazycc.uqcloud.net/lazycc"
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
		# something has gone really wrong if we reach here
		return -1

def check_connect(endpoint):
	try:
		err = requests.get(endpoint, timeout=5)
		return err.status_code == 200
	except requests.ConnectionError:
		return -1

def backup(data):
	with open("backup", 'a') as f:
		f.write(data + "\n")

	return 0

def clear_backup():
	with open("backup", 'w') as f:
		pass

def send_info(data):
	# convert to dict
	data = json.loads(data)

	# send a post request
	err = requests.post(endpoint, json=data)
	if err.status_code == 200:
		print(err.text)
		return 0
	# we shouldn't reach here
	else:
		return -1

def retry_send():
	while check_connect(endpoint) == -1:
		time.sleep(3)

	with open("backup", 'r') as f:
		for i in f:
			send_info(i)
			time.sleep(1)

	return 0

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
		if (err == -1):
			print("fatal error: try rebooting or checking sensor connection")
			sys.exit()
		# trigger on 100mm
		if (err <= 100):
			err = check_connect(endpoint)
			if not (err == -1):
				err = send_info(dtime())
				if (err == -1):
					print("error: send failed, request rejected")
			else:
				print("error: no connection to server")
				backup(dtime())
				print("... running in backup mode")
				err = retry_send()
				print("trying to resend data")
				time.sleep(0.5)
				if not err:
					print("resend was successful, continuing reading")
					clear_backup()
			# sleep before the next reading
			print("sensor is not reading ... user is washing hands")
			time.sleep(20)
			print("sensor is reading ...")

		# set delay time < 0.6s < don't delay for more
		time.sleep(0.5)
