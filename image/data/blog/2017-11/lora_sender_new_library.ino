///
///                 Arduino      SX1278_Lora
///                 GND----------GND   (ground in)
///                 3V3----------3.3V  (3.3V in)
/// interrupt 0 pin D2-----------DIO0  (interrupt request out)
///          SS pin D10----------NSS   (CS chip select in)
///         SCK pin D13----------SCK   (SPI clock in)
///        MOSI pin D11----------MOSI  (SPI Data in)
///        MISO pin D12----------MISO  (SPI Data out)
///


#include <SPI.h>
#include <RH_RF95.h>
#define DHT11_PIN 0
char sensor_string[]="Humidity: 00 Temperature: 00";
// Singleton instance of the radio driver
RH_RF95 SX1278;

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
    Serial.begin(9600);
    while (!Serial) ; // Wait for serial port to be available
   
    if (!SX1278.init())
        Serial.println("Notice:init failed");
    
    // Defaults init are 434.0MHz, 13dBm, Bw = 125 kHz, Cr = 4/5, Sf = 128chips/symbol, CRC on
}

void loop()
{
byte dht11_dat[5];
byte dht11_in;
char humstring[3];
char tmpstring[3];
//String humidi;
//String temper;
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
int x=0;
for(x=0;x<5;x++)
dht11_dat[x]=read_dht11_dat();
DDRC|=_BV(DHT11_PIN);
PORTC|=_BV(DHT11_PIN);
byte dht11_check_sum = dht11_dat[0]+dht11_dat[1]+dht11_dat[2]+dht11_dat[3];
if(dht11_dat[4]!=dht11_check_sum)
{
Serial.println("DHT11 checksum error");
}
itoa(dht11_dat[0], humstring, 10); 
itoa(dht11_dat[2], tmpstring, 10);
sensor_string[10] = humstring[0];
sensor_string[11] = humstring[1];
sensor_string[26] = tmpstring[0];
sensor_string[27] = tmpstring[1];
Serial.println("Sending to SX1278_server");
Serial.println(sensor_string);
// Send a message to SX1278_server
SX1278.send(sensor_string, sizeof(sensor_string));
Serial.println("mark0");
SX1278.waitPacketSent();
Serial.println("mark1");
// Now wait for a reply
uint8_t buf[RH_RF95_MAX_MESSAGE_LEN];
uint8_t len = sizeof(buf);
delay(1000);
Serial.println("mark2");
}
