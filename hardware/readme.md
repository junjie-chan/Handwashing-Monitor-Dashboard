# Raspberry Pi 4b Ultrasonic Sensor Integration (Model: A02YYUQ)

This repository contains the code to interface a Raspberry Pi 4b with an
ultrasonic sensor (model: A02YYUQ). It continuously reads distances from the
sensor. When a certain condition is triggered (e.g., a specific distance
threshold is breached), it sends data containing the date, time, and a unique
ID to a remote server.

## Table of Contents
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Usage](#usage)
- [Configuration](#configuration)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [License](#license)

## Prerequisites

1. Raspberry Pi 4b with Raspbian OS installed
2. Ultrasonic sensor model: A02YYUQ
3. Internet connection for sending data to the remote server
4. Python3.12 and up and necessary libraries (see Installation section)

## Installation

1. Clone this repository:
```bash
git clone git@bitbucket.org:junjie-chan/lazycc.git

## Usage
```bash
python3 run.py

## Troubleshooting
- Ensure the ultrasonic sensor is correctly connected to the Raspberry Pi GPIO
pins.
- Check for any error messages in the console output for hints on the problem.
- Verify the server URL and network connection.

## License


 Copyright (c) 2023 LAZYCC <student.services@uq.edu.au>

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

