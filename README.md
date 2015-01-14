# Intro

**CURRENTLY UNDER DEVELOPMENT**

A super simple RSVP system for my wedding and rehearsal dinner. Guests search by
name, which pulls up their entire party, at which point they can insert plus-one
names (if alotted) and input their responses.

# Setup

- Create a new MySQL database.
- Input credentials into `lib/db_conf.php` -- the relevant user needs SELECT,
INSERT, UPDATE, and DELETE but nothing else.
- Run `lib/setup.sql` against that new database.

# Security

This is designed for simplicity. While it protects against stupid crap like
SQL injection and XSS, there are only minimal protections against scraping, and
no protection against a guest modifying the RSVP of another guest if they know
another guest's name. That's just not the threat model I care about. This means
this is probably appropriate for a small, relatively obscure wedding RSVP where
you mostly trsut everyone with the URL, but is probably not appropriate for
anything highly visible.
