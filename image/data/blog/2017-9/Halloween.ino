#include <Adafruit_NeoPixel.h>
#ifdef __AVR__
#include <avr/power.h>
#endif

// Which pin on the Arduino is connected to the NeoPixels?
// On a Trinket or Gemma we suggest changing this to 1
#define PIN            6
#define radar          8
//#define EN           5

// How many NeoPixels are attached to the Arduino?
#define NUMPIXELS      6

// When we setup the NeoPixel library, we tell it how many pixels, and which pin to use to send signals.
// Note that for older NeoPixel strips you might need to change the third parameter--see the strandtest
// example for more information on possible values.
Adafruit_NeoPixel pixels = Adafruit_NeoPixel(NUMPIXELS, PIN, NEO_GRB + NEO_KHZ800);

int audiorandom;
int delayval = 500; // delay for half a second

void setup()
{
    // This is for Trinket 5V 16MHz, you can remove these three lines if you are not using a Trinket
#if defined (__AVR_ATtiny85__)
    if (F_CPU == 16000000) clock_prescale_set(clock_div_1);
#endif
    // End of trinket special code
    pixels.begin(); // This initializes the NeoPixel library.
    pinMode(radar,INPUT);//
    pinMode(0,OUTPUT);//
    pinMode(1,OUTPUT);//
    pinMode(2,OUTPUT);//
    pinMode(3,OUTPUT);//
    pinMode(6,OUTPUT);//
    Serial.begin(9600);
}


void loop()
{

    //while()
    // For a set of NeoPixels the first NeoPixel is 0, second is 1, all the way up to the count of pixels minus one.
    /*  for(int i=0; i<NUMPIXELS; i++)
      {

          // pixels.Color takes RGB values, from 0,0,0 up to 255,255,255
          pixels.setPixelColor(i, pixels.Color(0,0,0)); // Moderately bright green color.
          pixels.show(); // This sends the updated pixel color to the hardware.
      }*/
    while(digitalRead(radar)){
      Serial.println("wait 1 sec");
      delay(1000);
      Serial.println("waiting is over");
      if(digitalRead(radar)){
        Serial.println("Some one is coming");
        digitalWrite(0,HIGH);
        digitalWrite(1,HIGH);
        digitalWrite(2,HIGH);
        digitalWrite(3,HIGH);
        audiorandom= random(2,4);
        digitalWrite(audiorandom,LOW);
        Serial.println(audiorandom);
        delay(50);
   Serial.println("LED is on");
//        for(int i=0; i<3; i++)
//        {
            for(int i=0; i<NUMPIXELS; i++)
            {

                pixels.setPixelColor(i, pixels.Color(255,0,0)); // Moderately bright green color.
            }
            pixels.show();
            delay(5000);
                        for(int i=0; i<NUMPIXELS; i++)
            {

                pixels.setPixelColor(i, pixels.Color(0,255,0)); // Moderately bright green color.
            }
            pixels.show();
            delay(5000);
            for(int i=0; i<NUMPIXELS; i++)
            {

                pixels.setPixelColor(i, pixels.Color(0,0,0)); // Moderately bright green color.
            }
            pixels.show();
            Serial.println("LED off");
            delay(50);
 //       }
        Serial.println("wait 20 secs");
delay(10000);
delay(random(2000,10000));
Serial.println("it will work again");
       digitalWrite(audiorandom,HIGH);
      }
    }
}


