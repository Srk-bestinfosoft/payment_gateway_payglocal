# payment_gateway_payglocal
This project demonstrates a simple integration with the PayGlocal Payment Gateway using PHP and cURL. It includes API call implementation for payment initialization and handling the callback URL to process the payment response.

# PayGlocal Payment Gateway Integration using PHP & cURL

## Overview
This repository provides a simple implementation to integrate the PayGlocal Payment Gateway using PHP and cURL. The integration supports initializing payments, handling callbacks, and optionally saving transaction data in a database for further use.
the **PayGlocal Payment Gateway** using PHP and cURL. It includes functionality for payment initialization, callback handling, and transaction status retrieval. This setup is flexible and suitable for both **TEST** and **PRODUCTION** environments.

---
---

## File Descriptions

### 1. **config.php**
This file contains the configuration settings for the integration:
- Defines whether the application is running in **TEST** or **PRODUCTION** mode.
- Stores the API URL and authentication key (`x-gl-auth`) for the respective environment.
- Configures the callback URL that PayGlocal uses to send transaction responses.

#### Key Variables:
- `$env_mode`: Sets the environment (`TEST` or `PROD`).
- `$api_url`: PayGlocal API base URL.
- `$api_key`: Authentication token for API requests.
- `$callback_url`: The URL to handle PayGlocal's transaction response.

---

### 2. **paycollect.php**
This file handles payment initiation:
- Collects transaction and user details such as `merchantTxnId`, `totalAmount`, `txnCurrency`, `emailId`, and `phoneNumber`.
- Sends a POST request to the `/gl/v1/payments/initiate/paycollect` endpoint to start a transaction.
- Extracts the `redirectUrl` from the API response, which redirects users to complete the payment.

#### Key Logic:
- Dynamically generates a unique `merchantUniqueId` for every transaction using timestamps.
- Uses cURL to send the request with transaction details in JSON format.
- Processes and validates the response to extract the `redirectUrl`.

- **Replace the following values in the `/paycollect` payload**:
  - `merchantTxnId`: Replace with your unique merchant transaction ID.
  - `merchantUniqueId`: Replace with a timestamp-based unique ID for every transaction.
  - `totalAmount`: Replace with the transaction amount (e.g., `100` for ₹100).
  - `txnCurrency`: Replace with the appropriate currency code (e.g., `INR` for Indian Rupees).
  - `emailId`: Replace with the customer's email address.
  - `callingCode`: Replace with the customer's country code (e.g., `+91` for India).
  - `phoneNumber`: Replace with the customer's phone number.

#### Example Payload:
```json
{
  "merchantTxnId": "199652205010",
  "merchantUniqueId": "205010_21112023123045",
  "paymentData": {
    "totalAmount": "100",
    "txnCurrency": "INR",
    "billingData": {
        "emailId": "example@example.com",
        "callingCode": "+91",
        "phoneNumber": "9876543210"
    }
  },
  "merchantCallbackURL": "https://yourdomain.com/callback"
}
---

### 3. **callback.php**
This file handles the callback response from PayGlocal after a transaction is completed:
- Reads and decodes the JSON Web Token (JWT) posted by PayGlocal.
- Extracts key details from the payload, including:
  - `gid`: The gateway transaction ID.
  - `statusUrl`: The URL for checking the transaction status.
  - `Amount`: The transaction amount.
  - `merchantTxnId`: The merchant's transaction ID.
  - `paymentMethod`: The method of payment used.
  - `status`: The status of the transaction (e.g., success, failure).
- Displays the extracted data in an HTML table for easy debugging.

#### Key Features:
- Validates the structure and content of the JWT payload.
- Gracefully handles decoding errors or missing data fields.

---

### 4. **status.php**
This file retrieves the current status of a transaction:
- Sends a GET request to the `/gl/v1/payments/{gid}/status` endpoint.
- Uses the `gid` (gateway transaction ID) provided by the callback response to query the status.
- Processes and outputs the API response for debugging or further use.



## How to Use

### 1. Configuration
- Update `config.php` with your PayGlocal credentials and callback URL.
  ```php
  $env_mode = "TEST"; // Change to "PROD" for production
  $api_url = "https://api.uat.payglocal.in"; // Update to production URL for PROD
  $api_key = "your_api_key"; // Replace with your API key
  $callback_url = "https://yourdomain.com/callback"; // Replace with your actual callback URL
  
## Features
- Dynamically fetches the status URL from the transaction callback data.
- Uses cURL to securely communicate with the PayGlocal API.
- Payment initialization via PayGlocal API.
- Callback handling to process the payment response.
- Modular and customizable PHP code.
- Optional database integration to save transaction details.

---

## Requirements
- PHP 7.4 or higher
- cURL extension enabled
- PayGlocal API credentials (API Key, Secret)
- MySQL or any other relational database (optional for saving data)


---

## Installation
1. Clone this repository:
   ```bash
   git clone https://github.com/Srk-bestinfosoft/payment_gateway_payglocal.git
   cd payment_gateway_payglocal

