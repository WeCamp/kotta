kotta
=====

Requirements:
----

[Virtualbox](https://www.virtualbox.org/) <br/>
[Vagrant](https://www.vagrantup.com/) <br/>
[Ansible](http://www.ansible.com/home)


Getting started:
----
Clone the project

run `vagrant up`
_if anything goes wrong, try `vagrant provision` to continue_

Add the following lines to your `/etc/hosts` file:

    # Wecamp
    192.168.138.10 kotta.loc


Setup Project
=============

Create the environment file by copying `app/config/environment.dist.php` to `app/config/environment.php`

Run composer and boom.

Libraries
=========

We use [tmont/midiparser](https://github.com/tmont/midiparser) to parse uploaded midi files