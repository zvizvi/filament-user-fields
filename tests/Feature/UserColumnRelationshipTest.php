<?php

/**
 * Regression tests for https://github.com/zvizvi/filament-user-fields/issues/8
 *
 * The issue reported three failures with UserColumn:
 *   1. `->searchable()` on a relationship column threw errors.
 *   2. The column could not be used on the users table itself.
 *   3. The documented relationship usage was non-functional.
 *
 * These tests exercise all three scenarios end-to-end through a Livewire table.
 */

use Livewire\Livewire;
use Zvizvi\UserFields\Tests\Fixtures\Livewire\PostsTable;
use Zvizvi\UserFields\Tests\Fixtures\Livewire\TeamsTable;
use Zvizvi\UserFields\Tests\Fixtures\Livewire\UsersTable;
use Zvizvi\UserFields\Tests\Fixtures\Models\Post;
use Zvizvi\UserFields\Tests\Fixtures\Models\Team;
use Zvizvi\UserFields\Tests\Fixtures\Models\User;

beforeEach(function () {
    $this->alice = User::create(['name' => 'Alice', 'email' => 'alice@example.test']);
    $this->bob = User::create(['name' => 'Bob', 'email' => 'bob@example.test']);

    $this->postByAlice = Post::create(['title' => 'Post by Alice', 'author_id' => $this->alice->id]);
    $this->postByBob = Post::create(['title' => 'Post by Bob', 'author_id' => $this->bob->id]);
});

describe('relationship column (author.name)', function () {
    it('renders without errors and shows each author name', function () {
        Livewire::test(PostsTable::class)
            ->assertOk()
            ->assertCanSeeTableRecords([$this->postByAlice, $this->postByBob])
            ->assertCanRenderTableColumn('author.name')
            ->assertSee('Alice')
            ->assertSee('Bob');
    });

    // Problem #1 & #3: searchable on a relationship column used to throw.
    it('is searchable via dot notation', function () {
        Livewire::test(PostsTable::class)
            ->searchTable('Alice')
            ->assertCanSeeTableRecords([$this->postByAlice])
            ->assertCanNotSeeTableRecords([$this->postByBob]);
    });

    it('is sortable via dot notation', function () {
        Livewire::test(PostsTable::class)
            ->sortTable('author.name')
            ->assertCanSeeTableRecords([$this->postByAlice, $this->postByBob], inOrder: true)
            ->sortTable('author.name', 'desc')
            ->assertCanSeeTableRecords([$this->postByBob, $this->postByAlice], inOrder: true);
    });

    it('resolves the correct user per row even when the column is the raw relationship', function () {
        Livewire::test(PostsTable::class)
            ->assertCanRenderTableColumn('author')
            ->assertSee('Alice')
            ->assertSee('Bob');
    });
});

describe('on the users table itself (make(\'name\'))', function () {
    // Problem #2: the column could not be used when the user is the record.
    it('renders, searches and sorts using the record as the user', function () {
        Livewire::test(UsersTable::class)
            ->assertOk()
            ->assertCanSeeTableRecords([$this->alice, $this->bob])
            ->assertCanRenderTableColumn('name')
            ->assertSee('Alice')
            ->assertSee('Bob')
            ->searchTable('Bob')
            ->assertCanSeeTableRecords([$this->bob])
            ->assertCanNotSeeTableRecords([$this->alice])
            ->searchTable('')
            ->sortTable('name', 'desc')
            ->assertCanSeeTableRecords([$this->bob, $this->alice], inOrder: true);
    });
});

describe('to-many relationship column (members.name)', function () {
    it('renders every member of a team and stays searchable', function () {
        $team = Team::create(['name' => 'Core']);
        $team->members()->attach([$this->alice->id, $this->bob->id]);

        Livewire::test(TeamsTable::class)
            ->assertOk()
            ->assertCanSeeTableRecords([$team])
            ->assertCanRenderTableColumn('members.name')
            ->assertSee('Alice')
            ->assertSee('Bob')
            ->searchTable('Alice')
            ->assertCanSeeTableRecords([$team]);
    });
});
