## About Architecture:
The idea is simple to generate an encyption code for each URL encryption request, record the host and query params of the request.
Then encrypt the same url with our own Server URL and the encrypted key.
The key used for encryption is a custom generated key.
The mapping for the unique key and the request URL is done in the database

Note: It is a UI based application made on Laravel Admin Package
