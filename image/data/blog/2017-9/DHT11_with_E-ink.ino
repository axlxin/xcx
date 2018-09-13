//connection:
//Arduino   DHT11 
//  GND     GND
//  3.3     VCC
//  A0      data
#include <SmartEink.h>
#include <SPI.h>
#define DHT11_PIN 0
E_ink Eink;
byte read_dht11_dat()
{
byte i = 0;
byte result = 0;
for(i=0;i<8;i++)
{
while(!(PINC&_BV(DHT11_PIN)));
delayMicroseconds(30);
if(PINC&_BV(DHT11_PIN))
result|=(1<<(7-i));
while((PINC&_BV(DHT11_PIN)));
}
return result;
}
void setup()
{
  DDRC|=_BV(DHT11_PIN);
  PORTC|=_BV(DHT11_PIN);
}
void loop()
{
byte dht11_dat[5];
byte dht11_in;
char string[2];
byte i;
PORTC &= ~_BV(DHT11_PIN);
delay(18);
PORTC|=_BV(DHT11_PIN);
delayMicroseconds(40);
DDRC &= ~_BV(DHT11_PIN);
delayMicroseconds(40);
dht11_in = PINC & _BV(DHT11_PIN);
delayMicroseconds(80);
dht11_in=PINC & _BV(DHT11_PIN);
delayMicroseconds(80);
for(i=0;i<5;i++)
dht11_dat[ i]=read_dht11_dat();
DDRC|=_BV(DHT11_PIN);
PORTC|=_BV(DHT11_PIN);
byte dht11_check_sum = dht11_dat[0]+dht11_dat[1]+dht11_dat[2]+dht11_dat[3];
if(dht11_dat[4]!=dht11_check_sum) return;
itoa(dht11_dat[0], string, 10); //convert char to string
Eink.InitEink();
Eink.ClearScreen();// clear the screen
Eink.EinkP8x16Str(14,8,"Humidity:");
Eink.EinkP8x16Str(10,8,string); //print humidity
Eink.EinkP8x16Str(10,24,"%");
itoa(dht11_dat[2], string, 10); //convert char to string
Eink.EinkP8x16Str(6,8,"Temperature:");//print humidity
Eink.EinkP8x16Str(2,8,string);
Eink.EinkP8x16Str(2,24,".C");
Eink.RefreshScreen(); 
delay(5000);
}
