
#include <SoftwareSerial.h>
SoftwareSerial mySerial(0, 1); // RX, TX
#include <Adafruit_NeoPixel.h>
#define PIN 6
Adafruit_NeoPixel strip = Adafruit_NeoPixel(60, PIN, NEO_GRB + NEO_KHZ800);

void setup() {
  strip.begin();
  pinMode(6,OUTPUT);
  strip.show(); // Initialize all pixels to 'off'
  Serial.begin(9600);
}

void loop() {
     if(Serial.available() > 0) { 
    char data;
    data = Serial.read();
    Serial.write(Serial.read());
   
    switch (data)
    {
      case 'A': 
         colorSet(strip.Color(0, 255, 0), 0);  //Green
        digitalWrite(6, HIGH);
        
         break;
      case 'B': 
       colorSet(strip.Color(255, 0, 0), 0); //Red
       digitalWrite(6, HIGH);
       
        
        break;
      case 'C': 
        colorSet(strip.Color(0, 0, 255), 0);//Blue
       digitalWrite(6, HIGH);
        break;

      case 'D':
        colorSet(strip.Color(255, 255, 255), 0);//White
         break;

      case 'E':
 strip.setPixelColor(1,strip.Color(255, 0, 0));
          strip.setPixelColor(2,strip.Color(255, 127, 0));
           strip.setPixelColor(3,strip.Color(255, 255, 0));
          strip.setPixelColor(4,strip.Color(0, 255, 0));
           strip.setPixelColor(5,strip.Color(0, 0, 255));
          strip.setPixelColor(6,strip.Color(75, 0, 130));
           strip.setPixelColor(7,strip.Color(148, 0, 211));
          strip.setPixelColor(8,strip.Color(255, 0, 0));
           strip.setPixelColor(9,strip.Color(255, 127, 0));
          strip.setPixelColor(10,strip.Color(255, 255, 0));
           strip.setPixelColor(11,strip.Color(0, 255, 0));
          strip.setPixelColor(12,strip.Color(0, 0, 255));
           strip.setPixelColor(13,strip.Color(75, 0, 130));
          strip.setPixelColor(14,strip.Color(148, 0, 211));
           strip.setPixelColor(15,strip.Color(255, 0, 0));
          strip.setPixelColor(16,strip.Color(255, 127, 0));
         strip.show();
          digitalWrite(6, HIGH);
          break;
        
      default:
      digitalWrite(6,LOW);
    }

}

}

void colorSet(uint32_t c, uint8_t wait) {     // From NeoPixel Library
  for(uint16_t i=0; i<strip.numPixels(); i++) {
      strip.setPixelColor(i, c);
  }
   strip.show();
   delay(wait);
}





