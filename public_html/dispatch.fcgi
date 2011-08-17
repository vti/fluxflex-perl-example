#!/usr/bin/env /usr/bin/perl

use strict;
use warnings;

use Plack::Handler::FCGI;

my $app = sub {
    # our application
};

Plack::Handler::FCGI->new->run($app);
