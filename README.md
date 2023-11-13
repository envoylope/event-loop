# Envoylope EventLoop

[![Build Status](https://github.com/envoylope/event-loop/workflows/CI/badge.svg)](https://github.com/envoylope/event-loop/actions?query=workflow%3ACI)

Transmits AMQP heartbeats for [Envoylope][Envoylope] using a [ReactPHP][ReactPHP] [EventLoop][ReactPHP EventLoop].

## Usage
Install with Composer:

```shell
$ composer require envoylope/event-loop
```

## (Optionally) install Tasque and Tasque EventLoop

If you are running a traditional PHP application, a [ReactPHP][ReactPHP] [EventLoop][ReactPHP EventLoop] may regularly be blocked
by synchronous logic/IO. This can be mitigated somewhat by [Tasque][Tasque] [EventLoop][Tasque EventLoop],
which implements [green threads][Green threads] for PHP.

See the respective usage instructions linked above for configuring the Tasque/EventLoop Nytris packages.

### Configuring the bundle

(TODO)

[Envoylope]: https://github.com/envoylope
[Green threads]: https://en.wikipedia.org/wiki/Green_thread
[ReactPHP]: https://reactphp.org/
[ReactPHP EventLoop]: https://github.com/reactphp/event-loop
[Tasque]: https://github.com/nytris/tasque
[Tasque EventLoop]: https://github.com/nytris/tasque-event-loop
