#include <dht.h>
#include <SoftwareSerial.h>

#define TxD A0
#define RxD A1
#define DHT11 A5

#define Delay 36
#define No_of_device 4

#define D1 2
#define D2 3
#define D3 4
#define D4 5

dht DHT;
SoftwareSerial bluetooth(TxD, RxD);

char state[No_of_device];

void setup() {
  bluetooth.begin(9600);
  Serial.begin(9600);
  pinMode(D1,OUTPUT);
  pinMode(D2,OUTPUT);
  pinMode(D3,OUTPUT);
  pinMode(D4,OUTPUT);
}

void loop() {
  receivedata();
  senddata();
}

void receivedata()
{
  int times = 0;
  while(times < Delay) {
    int i = 0;
    bluetooth.read();
    for(i=1; i<=No_of_device; i++) {
      if(bluetooth.available() > 0) {
        state[i] = char(bluetooth.read());
        Serial.println(state[i]);
        if(state[i] == '0') {
          if(i==1) {
            digitalWrite(D1,HIGH);
          } else if(i==2) {
            digitalWrite(D2,HIGH);
          } else if(i==3) {
            digitalWrite(D3,HIGH);
          } else if(i==4) {
            digitalWrite(D4,HIGH);
          }
        } else {
          if(i==1) {
            digitalWrite(D1,LOW);
          } else if(i==2) {
            digitalWrite(D2,LOW);
          } else if(i==3) {
            digitalWrite(D3,LOW);
          } else if(i==4) {
            digitalWrite(D4,LOW);
          }
        }
      }
    }
    bluetooth.read();
    delay(5000);
    times++;
  }
}

void senddata()
{
  tempdisplay();
  String temp = String(DHT.temperature);
  String hum = String(DHT.humidity);
  bluetooth.println(temp + "," + hum);
}

void tempdisplay()
{
  int chk = DHT.read11(DHT11);
  Serial.print("Temperature = ");
  Serial.print(DHT.temperature);
  Serial.print(" Humidity = ");
  Serial.println(DHT.humidity);
}
