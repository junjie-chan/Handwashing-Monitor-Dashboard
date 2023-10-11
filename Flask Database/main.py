# pip install flask
# pip install mysql-connector-python


"""

mysql -u root -p
xxxx


create database flask;

use flask;


CREATE TABLE device_table (
    id INT AUTO_INCREMENT PRIMARY KEY,
    time VARCHAR(255) NOT NULL,
    date VARCHAR(255) NOT NULL,
    device_id  VARCHAR(255) NOT NULL
);

"""

"""
curl -X PUT -H "Content-type: application/json" -d "{\"time\" : \"12:12:12\", \"date\" : \"2020-12-12\", \"device_id\" : \"001\"}" "localhost:5000/put_data"



curl -X GET http://127.0.0.1:5000/get_data
open chrome : http://127.0.0.1:5000/get_data

"""

from flask import Flask, request, jsonify
import mysql.connector

app = Flask(__name__)


connection = mysql.connector.connect(
    host="localhost",
    user="root",
    password="6001",  # todo
    database="flask"
)


@app.route('/get_data', methods=["GET"])
def hello():
    cursor = connection.cursor()

    query = 'SELECT * from device_table'
    cursor.execute(query)

    data = cursor.fetchall()

    cursor.close()

    response = jsonify(data)
    return response


def insert_database(json):
    time = json['time']
    date = json['date']
    device_id = json['device_id']

    cursor = connection.cursor()

    insert_query = "INSERT INTO device_table (time, date, device_id) VALUES (%s, %s, %s)"

    data_to_insert = (time, date, device_id)

    cursor.execute(insert_query, data_to_insert)

    connection.commit()

    cursor.close()
    # connection.close()


@app.route('/put_data', methods=['PUT'])
def handle_data():
    content_type = request.headers.get('Content-Type')
    if (content_type == 'application/json'):
        json = request.json
        print("time", json['time'])
        print("date", json['date'])
        print("device_id", json['device_id'])

        insert_database(json)

        return json
    else:
        return 'Content-Type not supported!'


if (__name__ == "__main__"):
    app.run(debug=True)
