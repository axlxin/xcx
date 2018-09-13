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

// Singleton instance of the radio driver
RH_RF95 SX1278;

int led = 9;

void setup()
{

    pinMode(led, OUTPUT);
    Serial.begin(9600);
    while (!Serial) ; // Wait for serial port to be available
    if (!SX1278.init())
        Serial.println("init failed");
    // Defaults init are 434.0MHz, 13dBm, Bw = 125 kHz, Cr = 4/5, Sf = 128chips/symbol, CRC on
}

void loop()
{
    if (SX1278.available())
    {
        // Should be a message for us now
        uint8_t buf[RH_RF95_MAX_MESSAGE_LEN];
        uint8_t len = sizeof(buf);
        if (SX1278.recv(buf, &len))
        {
            digitalWrite(led, HIGH);
            //RH_RF95::printBuffer("request: ", buf, len);
            Serial.print("Receive Message: ");
            Serial.println((char*)buf);
            //Serial.print("RSSI: ");
            //Serial.println(SX1278.lastRssi(), DEC);
            // Send a reply
            digitalWrite(led, LOW);
        }
        else
        {
            Serial.println("recv failed");
        }
    }
}


