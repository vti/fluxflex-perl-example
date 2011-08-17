#!/usr/bin/env perl

use strict;
use warnings;

use DateTime;
use Plack::Handler::FCGI;

my $BIRTHDAY_DAY   = 23;
my $BIRTHDAY_MONTH = 7;

my $app = sub {
    my $env = shift;

    my $current_time = DateTime->now;

    my $body;
    if (   $current_time->day == $BIRTHDAY_DAY
        && $current_time->month == $BIRTHDAY_MONTH)
    {
        $body = 'Happy birthday!';
    }
    else {
        my $next_birthday = DateTime->new(
            year  => $current_time->year,
            month => $BIRTHDAY_MONTH,
            day   => $BIRTHDAY_DAY
        );

        $next_birthday += DateTime::Duration->new(years => 1)
          if $current_time > $next_birthday;

        my $diff = $next_birthday->subtract_datetime_absolute($current_time);

        $body =
          'Please, wait for just ' . $diff->in_units('seconds') . ' seconds.';
    }

    return [200, ['Content-Length' => length($body)], [$body]];
};

Plack::Handler::FCGI->new->run($app);
