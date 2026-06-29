# Web Interface

## Overview

The web interface is the primary tool for configuring and controlling the smart home system. Unlike the Telegram bot, which focuses on everyday operation and quick remote access, the web interface provides access to every configurable feature and operating parameter available within the system.

The interface is organized into several dedicated pages, each responsible for a specific subsystem:

* System configuration
* Lighting and ventilation control
* Security management

The interface was designed primarily for portrait orientation and optimized for smartphone use, allowing convenient operation without requiring a dedicated mobile application.

The web service is hosted by **Apache HTTP Server (Apache2)** running on the Orange Pi under Debian Linux. Apache processes incoming HTTP requests, executes the server-side application logic, and delivers dynamically generated web pages to the user's browser.

As described in other sections of this project, the web interface is intentionally accessible **only from the local network**.

This decision is not related to the availability of a public IP address, but is instead based on cybersecurity considerations. The home router provides an additional security layer by:

* allowing access only to registered client devices;
* filtering clients by MAC address;
* disabling SSID broadcasting;
* using a strong Wi-Fi password.

The wireless network provides reliable coverage at the apartment entrance, allowing the security system to be disarmed from a smartphone before unlocking the entrance door.

---

## Security Page

![▶ Web-interface Security page](https://github.com/user-attachments/assets/2a1e025c-6f8e-42c2-952f-84f1f19b82f4)

The **Security** page provides the primary controls for operating the apartment's security system.
<p align="center">
  <img src="/images/screenshot/Web-interface-security-on.jpg" height="400">
  <img src="/images/screenshot/Web-interface-security-off.jpg" height="400">
</p>
The main window allows the user to:

* Arm the security system
* Disarm the security system
* Clear an active alarm after it has been triggered

The page also displays the current status of the protected perimeter, including:

* Entrance door lock
* Entrance door
* Ventilation window

### Security Settings
<p align="center">
  <img src="/images/screenshot/Web-interface-security-settings.jpg" height="400">
</p>
Selecting **Settings** opens an additional configuration page containing advanced security features.

Available options include:

* Audible confirmation using the indoor siren when the security mode changes, similar to the feedback provided by automotive alarm systems.
* Visual reminder if the entrance door or lock has not been properly secured by flashing the hallway lighting.
* Arming and disarming the security system using GSM calls.
* Automatic GSM call notification when an alarm is triggered.
* Automatic arming when the entrance door lock reaches its fully locked position, detected by a reed switch.
* Automatic shutdown of all lighting when the apartment is placed into security mode.
* A "Light Assistant" feature that automatically turns on the hallway lighting when the apartment is entered after disarming the security system, providing convenient illumination during nighttime entry.
* Random flashing of lighting circuits during an alarm event to attract attention and simulate occupancy.
* Activation of the 110 dB siren during alarm conditions.

---

## Lighting Page

![▶ Web-interface switch panel simplified](https://github.com/user-attachments/assets/98d5e2ad-1f59-4b85-a53a-3d53f88106fe)

The **Lighting** page provides manual control of all lighting circuits and ventilation outputs.

The main interface contains two operating modes.

### Universal Mode

The **Universal** tab is intended for everyday operation.
<p align="center">
  <img src="/images/screenshot/Web-interface-switch-panel-universal.jpg" height="400">
</p>
It closely mirrors the behavior of the physical wall push buttons and provides access only to the most frequently used local lighting circuits, which covers the vast majority of daily use cases.

The final two indicators are not control buttons. They simply display the current operating status of the gas boiler and air conditioner.

### Manual Mode

The **Manual** tab displays the complete structure of all lighting circuits throughout the apartment.
<p align="center">
  <img src="/images/screenshot/Web-interface-switch-panel-manual.jpg" height="400">
</p>
This mode is intended primarily for maintenance, diagnostics, or situations requiring direct access to every individual lighting output.

### Communication Mechanism

Each user interaction generates an asynchronous AJAX request sent to the web server.

The transmitted parameter identifies the selected control element.

After processing the request, the server:

1. Executes the corresponding automation logic.
2. Switches the appropriate relay output.
3. Returns the updated device state to the browser.

The web interface then updates the graphical state of the corresponding control element.

To maintain synchronization with the physical installation, the page automatically refreshes the system status once per second.

---


## Settings Page

![▶ Web-interface Settings Page](https://github.com/user-attachments/assets/6f2073b5-2c1d-4bf3-be12-194df20a213f)

The **Settings** page provides centralized access to all configurable system parameters.

The interface is organized as a collection of collapsible sections, each dedicated to a specific subsystem.
<p align="center">
  <img src="/images/screenshot/Web-interface-prefences-panel-0.jpg" height="400">
</p>

Available categories include:

* Energy Monitoring
* Environmental Monitoring
* Gas Boiler
* Air Conditioner
* Ventilation
* Blackout
* Security
* Timers and Setpoints
* GSM Modem

Each section contains configuration parameters specific to its subsystem, allowing the entire automation platform to be adjusted without modifying the firmware.


## Energy Monitoring

The **Energy Monitoring** section provides real-time information about the electrical parameters of both the apartment's AC mains supply and the internal low-voltage power system.
<p align="center">
  <img src="/images/screenshot/Web-interface-prefences-panel-1.jpg" height="400">
</p>

### Monitored Parameters

#### AC Power Supply

The following parameters are continuously measured:

* Mains voltage
* Load current
* Instantaneous power consumption

#### 12 V Power Supply

The system also monitors the auxiliary power supply used by the automation hardware:

* Output current
* Power consumption
* Internal power supply temperature

This information allows the user to evaluate system load and detect abnormal operating conditions.

### Available Functions

The page also provides several power-management options intended for operation during backup power conditions.

#### Energy Saving Mode

The energy-saving mode can be enabled manually.

When active, lighting automation prioritizes only the minimum number of lighting circuits required for comfortable operation, reducing overall power consumption.

This feature is primarily intended for operation from a portable power station or backup battery.

#### Automatic Energy Saving

Energy-saving mode can also be enabled automatically whenever the system detects that it is operating from the backup power source.

#### Ventilation Lockout

Forced ventilation can be automatically disabled while operating from backup power in order to reduce electrical load and extend battery runtime.


## Thermal Monitoring

The **Thermal Monitoring** section displays environmental measurements collected from indoor and outdoor sensors.
<p align="center">
  <img src="/images/screenshot/Web-interface-prefences-panel-2.jpg" height="400">
</p>

Available information includes:

* Indoor temperature
* Outdoor temperature
* Indoor humidity
* Outdoor humidity

To compensate for sensor installation conditions or calibration differences, the interface allows a user-defined temperature offset within the range of **−3 °C to +3 °C**.

This calibration is applied only to the displayed and control values and does not affect the raw sensor measurements.


## Gas Boiler

This page contains all controls and operating parameters related to the heating thermostat.
<p align="center">
  <img src="/images/screenshot/Web-interface-prefences-panel-3.jpg" height="400">
</p>

### Available Functions

* Enable or disable the heating thermostat
* Display the current indoor temperature
* Display the active temperature setpoint
* Modify the primary heating setpoint
* Display the measured temperature variation during the most recent heating cycle (effective hysteresis)
* Display the duration of the previous boiler cycle (typically **30–80 minutes** during winter)


### Economy Heating Mode

The thermostat supports an independent economy setpoint.

When the security system is armed (indicating that the apartment is unoccupied), the thermostat automatically switches to the economy temperature in order to reduce gas consumption.

When the security system is disarmed, the thermostat automatically restores the normal comfort setpoint.

The page allows the user to:

* Enable or disable economy mode
* View the current economy temperature
* Configure the secondary temperature setpoint

---

## Air Conditioner

The **Air Conditioner** page provides complete control over the cooling and heating thermostat.
<p align="center">
  <img src="/images/screenshot/Web-interface-prefences-panel-4.jpg" height="400">
</p>

### Available Functions

* Enable or disable cooling mode
* Enable or disable heating mode
* Display the current indoor temperature
* Display the active thermostat setpoint
* Modify the primary temperature setpoint
* Display the current fan speed

### Economy Mode

Similar to the heating system, the air conditioner supports an independent economy temperature.

When the apartment is placed into security mode, the cooling thermostat automatically switches to the secondary setpoint, reducing unnecessary energy consumption while nobody is home.

The normal temperature is restored automatically after the security system is disarmed.

The interface allows the user to:

* Enable or disable economy mode
* View the secondary temperature setpoint
* Configure the economy temperature

### Open Window Protection

The air conditioner can be automatically prevented from starting whenever a window is open.

Once the window is closed, thermostat operation resumes automatically.

This prevents unnecessary energy losses during ventilation.

### Emergency Freeze Protection

An optional emergency function allows the air conditioner to operate in heating mode if the indoor temperature falls to approximately **6 °C**.

The feature was designed as an emergency safeguard in the event of a complete gas boiler failure during winter, preventing freezing of the heating system.

In normal operation, this protection has never been required.

### Mutual Interlocking

The heating and cooling subsystems are mutually interlocked within the Arduino firmware.

Consequently:

* Cooling cannot operate while the gas boiler is active.
* Boiler heating cannot operate while cooling is active.
* Selecting one operating mode automatically disables the opposite mode.

Likewise, the air conditioner's heating and cooling modes are also mutually exclusive, ensuring that only one operating mode can be active at any given time.


## Ventilation

The **Ventilation** section provides configuration options for the apartment's forced exhaust ventilation system.
<p align="center">
  <img src="/images/screenshot/Web-interface-prefences-panel-5.jpg" height="400">
</p>
Several automation scenarios can be enabled or disabled independently.

### Available Functions

* Flash the room lighting briefly whenever a ventilation fan is switched on or off, providing visual confirmation of the operation.
* Prevent the bedroom ventilation fan from starting unless the window is open in the ventilation position.
* Automatically start bedroom ventilation when the corresponding window is opened for ventilation.
* Automatically stop bedroom ventilation after a user-defined operating period.
* Prevent the bathroom ventilation fan from starting unless the ventilation window is open.
* Automatically keep the bathroom ventilation running for a configurable period after the bathroom lighting has been switched off.

These scenarios improve ventilation efficiency while reducing unnecessary energy consumption.


## Blackout

The **Blackout** section configures the actions executed automatically when the security system is armed.
<p align="center">
  <img src="/images/screenshot/Web-interface-prefences-panel-6.jpg" height="400">
</p>
The name originates from the concept of "blackout" and reflects the idea of leaving the apartment with all unnecessary electrical loads switched off.

The user can select which rooms should automatically have their:

* Lighting
* Ventilation

disabled when the apartment is placed into security mode.

This feature provides a convenient "leaving home" scenario without requiring manual shutdown of each individual device.


## Security

This section provides configuration options identical to those available on the dedicated **Security** page.
<p align="center">
  <img src="/images/screenshot/Web-interface-prefences-panel-7.jpg" height="400">
</p>
In addition, it allows the user to manually trigger or clear the alarm state for testing and maintenance purposes.

This functionality simplifies verification of alarm scenarios without requiring actual intrusion events.


## Timers and Setpoints

The **Timers and Setpoints** section centralizes all configurable timing parameters used throughout the automation platform.
<p align="center">
  <img src="/images/screenshot/Web-interface-prefences-panel-8-1.jpg" height="400">
  <img src="/images/screenshot/Web-interface-prefences-panel-8-2.jpg" height="400">
</p>
Instead of embedding fixed timing values in the firmware, nearly every delay can be adjusted directly from the web interface.

### Configurable Parameters

* Service-function activation timeout for mechanical push buttons
* Timeout used for multi-function lighting command recognition
* Bathroom ventilation overrun timer
* Bedroom and wardrobe ventilation timer
* Entrance door lock reminder duration
* Entrance door reminder duration
* Flashing frequency for visual notifications
* Electrical sensor polling interval
* Indoor environmental sensor polling interval
* Outdoor environmental sensor polling interval
* Minimum boiler operating time
* Doorbell lighting notification duration
* 12 V power supply temperature polling interval
* Minimum air-conditioner operating time
* Minimum compressor off-time after reaching the thermostat setpoint
* Delay before allowing the air conditioner to restart after a ventilation window has been closed

Most of these parameters were introduced during long-term operation to fine-tune system behavior without modifying the firmware.


## GSM Modem

The **GSM Modem** page displays the current operating status of the industrial GSM communication module.
<p align="center">
  <img src="/images/screenshot/Web-interface-prefences-panel-9.jpg" height="400">
</p>

### Available Information

* Cellular signal strength
* Network registration status
* Modem availability

### Account Balance

The **Account Balance** button initiates a USSD request to the mobile network operator.

The modem receives the operator's response, which is then:

* processed by the software,
* stored in the database,
* displayed directly within the web interface.

This feature allows the user to verify the SIM card balance without physically interacting with the modem or a mobile phone.


