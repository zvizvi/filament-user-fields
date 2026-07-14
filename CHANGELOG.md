# Changelog

All notable changes to `user-fields` will be documented in this file.

## 0.0.7 - 2026-07-14

### What's Changed

* All display components (`UserColumn`, `UserEntry`, `UserStackedColumn`, `UserStackedEntry`) now support dot notation (`UserColumn::make('author.name')`) — native `searchable()` and `sortable()` work out of the box, and the relationship is eager-loaded automatically
* Components can now be used on the users table itself (`UserColumn::make('name')`) — the record is used as the user
* Multi-user dot notation (`UserColumn::make('teamMembers.name')`) resolves each item to its user model, so avatars stay correct even when two users share the same name
* Removed the non-existent `relationship()` method from the README

## 0.0.5 - 2026-07-10

### What's Changed

* Bump ramsey/composer-install from 3 to 4 by @dependabot[bot] in https://github.com/zvizvi/filament-user-fields/pull/9
* Bump dependabot/fetch-metadata from 2.5.0 to 3.1.0 by @dependabot[bot] in https://github.com/zvizvi/filament-user-fields/pull/12

**Full Changelog**: https://github.com/zvizvi/filament-user-fields/compare/0.0.4...0.0.5

## 1.0.0 - 202X-XX-XX

- initial release
