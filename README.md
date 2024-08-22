# SoftWax Correlation Ids Bundle

## Installation

`composer require softwax/correlation-ids-bundle`

----------

Purpose:
- giving request/process correlation capabilities to your project.
- injecting correlation data as an extra arguments to all monolog records.

The basic idea of correlation id is to trace process between applications (useful in microservices architecture).

Example: the root application generates correlation id and passes it to next application which in turn passes it to the next and so on.

```
+-------+  current: 3b5263fa-1644-4750-8f11-aaf61e58cd9e
| App A |  parent: null
+---+---+  root: 3b5263fa-1644-4750-8f11-aaf61e58cd9e
    |
    |
    v
+-------+  current: 3fc044d9-90fa-4b50-b6d9-3423f567155f
| App B |  parent: 3b5263fa-1644-4750-8f11-aaf61e58cd9e
+---+---+  root: 3b5263fa-1644-4750-8f11-aaf61e58cd9e
    |
    |
    v
+-------+  current: 6a051d24-aa5b-4c57-bcb4-bbbb7eda1c16
| App C |  parent: 3fc044d9-90fa-4b50-b6d9-3423f567155f
+-------+  root: 3b5263fa-1644-4750-8f11-aaf61e58cd9e
```
