import sys
import serial
import requests
import json
import time

def AvailablePorts():
    if sys.platform.startswith('win'):
        ports = ['COM' + str(i + 1) for i in range(256)]
    elif sys.platform.startswith('linux') or sys.platform.startswith('cygwin'):
        # this is to exclude your current terminal "/dev/tty"
        ports = glob.glob('/dev/tty[A-Za-z]*')
    elif sys.platform.startswith('darwin'):
        ports = glob.glob('/dev/tty.*')
    else:
        raise EnvironmentError('Unsupported platform')
    result = []
    for port in ports:
        try:
            s = serial.Serial(port, 9600)
            s.close()
            result.append(port)
        except (OSError, serial.SerialException):
            pass
    return result

def PortSelect():
    ports = AvailablePorts()
    if len(ports)==0:
        print("No Ports Available!!!\nCheck Bluetooth is Active and Coonected to device or not")
        exit()
    else:
        print("Available Ports : ")
        for port in ports:
            print(port)
        portsel = input("\nEnter port number from the available list: ")
        for port in ports:
            if port==portsel.upper():
                return port
        else:
            PortSelect()

def uploaddata():
    try:
        input_data = bluetooth.readline()
        if(len(input_data))==0:
            pass
        else:
            string_data = input_data.decode()
            data_list = string_data.split(',')
            data_list = [float(x) for x in data_list]
            data = ["Uploading", data_list[0], data_list[1]]
            req = requests.post(url, json=data)
            if req.status_code == 200:
                status = req.text 
            else:
                status = "Failure"
            print('PROCESS=>',data[0],'\tTEMPERATURE=>',data[1],'\tHUMADITY=>',data[2],'\tSTATUS=>',status)
    except Exception as e:
        print("\nError Occur...!!!\n",e)

def devicestatus():
    data = ["Receiving"]
    try:
        req = requests.post(url, json=data)
        if req.status_code == 200:
            status = req.text
            bluetooth.write(status.encode())
        else:
            status = "Failure"
        print('PROCESS=>',data[0],'\tSTATUS=>',status)
    except requests.exceptions.RequestException as e:
        print("\nError Occur...!!!\n",e)
        
        
port = PortSelect()

url = 'https://final2k20.000webhostapp.com/request/arduino.php';
#url = 'http://localhost/smartcontrol/request/arduino.php';

try:
    bluetooth=serial.Serial(port, 9600, timeout=1)
    bluetooth.flushInput()
    input_data = bluetooth.readline()
    print("\nReady!!!\n")
    while(1):
        time.sleep(2)
        devicestatus()
        uploaddata()
        
except serial.SerialException as e:
        print("\nError...!!!\n",e)

finally:
    print("Thanks...Try Again...!!!")
