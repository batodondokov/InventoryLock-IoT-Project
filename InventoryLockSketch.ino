#include <ESP8266WiFi.h>
#include <PubSubClient.h>
#include <Servo.h>
#define ServoPin 2

const char* ssid = "YOUR_SSID";
const char* password = "YOUR_PASSWORD";
const char* mqtt_server = "broker.emqx.io";

WiFiClient espClient;
PubSubClient client(espClient);
Servo myservo;
int status;

void setup() {
  Serial.begin(115200);
  setup_wifi();
  myservo.attach(ServoPin);
  client.setServer(mqtt_server, 1883);
  client.setCallback(callback);
}

void loop() {
  if (!client.connected()) {
    reconnect();
  }
  client.loop();
}

void setup_wifi() {
  delay(10);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
  }
}

void reconnect() {
  while (!client.connected()) {
    if (client.connect("ESP01")) {
      client.subscribe("InventoryLock/status");
    } else {
      delay(5000);
    }
  }
}

void callback(char* topic, byte* payload, unsigned int length) {
  Serial.print("Message received on topic: ");
  Serial.print(topic);
  Serial.print(". Message: ");
  status = (char)payload[0] - '0';
  Serial.print(status);
  handleServo(status);
  Serial.println();
}
