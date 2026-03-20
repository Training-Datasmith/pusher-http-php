# Architecture: pusher-http-php

## Purpose

The official PHP server SDK for the Pusher Channels real-time messaging service. Provides methods for triggering events, authenticating private/presence channels, and verifying webhooks.

## Directory Structure

```
src/
  Pusher.php               - Main client class; trigger(), authenticate(), webhook verification
  Pusher_Interface.php     - Contract the Pusher client must satisfy
  Pusher_Instance.php      - Value object holding connection configuration (key, secret, cluster)
  Pusher_Crypto.php        - End-to-end encryption helpers for encrypted channels
  Webhook.php              - Value object representing an incoming Pusher webhook
  Pusher_Exception.php     - Base exception for SDK errors
  Api_Error_Exception.php  - Thrown when the Pusher API returns an error response
```

## Key Design Decisions

- **Interface-first**: `Pusher_Interface` allows test doubles and alternative implementations to be injected without depending on the concrete `Pusher` class.
- **E2E encryption**: `Pusher_Crypto` implements Pusher's encrypted channel spec using symmetric encryption, keeping message content opaque to the Pusher infrastructure.
- **HTTP client agnostic**: The client uses Guzzle internally but the interface only exposes the logical operations, allowing the HTTP layer to be swapped.

## Extension Points

- Implement `Pusher_Interface` to create a test double that records triggered events.
- Extend `Pusher_Crypto` to support custom key derivation.

## Dependency Flow

```
Pusher (implements Pusher_Interface)
  └─> trigger() / trigger_batch()  — POST to Pusher Events API
  └─> authenticate()               — generates auth signatures for private/presence channels
  └─> webhook()                    — validates incoming webhook HMAC signature
  └─> Pusher_Crypto               — encrypts/decrypts E2E channel messages
```
