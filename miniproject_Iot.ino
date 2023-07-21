#include <WiFi.h>
#include <HTTPClient.h>
#include <time.h>
#include <SPI.h>
#include <MFRC522.h>

//RFID*******************************************************************
#define SS_PIN 5
#define RST_PIN 22
//LED*******************************************************************
const int greenLED = 25;
const int redLED = 26;
//ULTRASONIC******************************************************************
#define ULTRASONIC_TRIG_PIN 12
#define ULTRASONIC_ECHO_PIN 13
#define ULTRASONIC_MAX_DISTANCE 35

float duration_us, distance_cm;
//************************************************************************
MFRC522 mfrc522(SS_PIN, RST_PIN); // Create MFRC522 instance.
//************************************************************************

const char *ssid = "EmpireRental@Unifi-5G";
const char *password = "9Jahanam";
const char *device_token = "rfidsensor";

//************************************************************************
int timezone = 8 * 3600; 
int time_dst = 0;
String getData, Link;
String OldCardID = "";
unsigned long previousMillis2 = 0;
String URL = "http://192.168.0.105/lendingbooksystem/getdata.php"; 

bool rfidProcessed = false;
unsigned long rfidResetTime = 0;
unsigned long rfidResetInterval = 20 * 1000; // 20 second
//************************************************************************

void setup()
{
  delay(1000);
  Serial.begin(115200);
  SPI.begin();             // Init SPI bus
  mfrc522.PCD_Init();      // Init MFRC522 card

  //---------------------------------------------
  connectToWiFi();
  //---------------------------------------------
  pinMode(ULTRASONIC_TRIG_PIN, OUTPUT);  // set ESP32 pin to output mode
  pinMode(ULTRASONIC_ECHO_PIN, INPUT);   // set ESP32 pin to input mode
  //LED**************************************************************
  pinMode(greenLED, OUTPUT);
  pinMode(redLED, OUTPUT);
  //---------------------------------------------
  configTime(timezone, time_dst, "pool.ntp.org", "time.nist.gov");
}

//************************************************************************
void loop()
{
  // Reset the RFID processing flag and update the reset time
  if (millis() - rfidResetTime >= rfidResetInterval)
  {
    rfidProcessed = false;
    rfidResetTime = millis();
  }

  // check if there's a connection to Wi-Fi or not
  if (!WiFi.isConnected())
  {
    connectToWiFi(); // Retry connecting to Wi-Fi
  }

  digitalWrite(ULTRASONIC_TRIG_PIN, HIGH);
  delayMicroseconds(10);
  digitalWrite(ULTRASONIC_TRIG_PIN, LOW);

  // measure duration of pulse from ECHO pin
  duration_us = pulseIn(ULTRASONIC_ECHO_PIN, HIGH);
  // calculate the distance
  distance_cm = 0.017 * duration_us;
  //---------------------------------------------
  if (millis() - previousMillis2 >= 15000)
  {
    previousMillis2 = millis();
    OldCardID = "";
  }
  delay(50);
  //---------------------------------------------

  // Look for a new card
  if (!rfidProcessed && mfrc522.PICC_IsNewCardPresent() && mfrc522.PICC_ReadCardSerial())
  {
    String CardID = "";
    for (byte i = 0; i < mfrc522.uid.size; i++)
    {
      CardID += mfrc522.uid.uidByte[i];
    }
    //---------------------------------------------
    Serial.print("distance: ");
    Serial.print(distance_cm);
    Serial.println(" cm");
    if (distance_cm < ULTRASONIC_MAX_DISTANCE)
    {
      SendCardID(CardID);
      digitalWrite(greenLED, HIGH);
      Serial.println("Input successful. Next RFID input allowed in:");
      unsigned long remainingTime = rfidResetInterval - (millis() - rfidResetTime);
      Serial.print(remainingTime / 1000); // Convert to seconds
      Serial.println(" seconds.");
      delay(1000);
      digitalWrite(greenLED, LOW);
      
      // Set the flag to true to indicate the RFID input has been processed
      rfidProcessed = true;
      rfidResetTime = millis(); // Update the RFID reset time
    }  
    else
    {
      Serial.println("Not in range. Resetting RFID input...");
      digitalWrite(redLED, HIGH); 
      delay(3000);
      digitalWrite(redLED, LOW);
      // Reset the RFID processing flag
      rfidProcessed = false;
      rfidResetTime = millis(); // Update the RFID reset time
    }
    Serial.println("---------------------------------");
  }  
}

//************send the Card UID to the website*************
void SendCardID(String Card_uid)
{
  Serial.println("Sending the Card ID");
  if (WiFi.isConnected())
  {
    HTTPClient http; // Declare object of class HTTPClient
    // GET Data
    getData = "?card_uid=" + String(Card_uid) + "&device_token=" + String(device_token); // Add the Card ID to the GET array to send it
    // GET method
    Link = URL + getData;
    http.begin(Link);
    int httpCode = http.GET();   // Send the request
    String payload = http.getString(); // Get the response payload

    Serial.println(httpCode);   // Print HTTP return code
    Serial.println(Card_uid);   // Print Card ID
    Serial.println(payload);    // Print request response payload

    delay(100);
    http.end(); // Close connection
  }
}

//********************connect to the WiFi******************
void connectToWiFi()
{
  WiFi.disconnect(true);        // Disconnect from any previous Wi-Fi connection
  delay(1000);
  WiFi.mode(WIFI_STA);          // Set ESP32 in station mode
  Serial.print("Connecting to ");
  Serial.println(ssid);
  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED)
  {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("Connected");

  Serial.print("IP address: ");
  Serial.println(WiFi.localIP()); // IP address assigned to your ESP

  delay(1000);
}
