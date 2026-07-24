<?php

/**
 * Smoke coverage for every component the package ships, exercised through the
 * real Filament rendering pipeline (Livewire) rather than in isolation:
 *
 *   - UserColumn         — table text column with avatar + name
 *   - UserStackedColumn  — table image column with stacked avatars
 *   - UserEntry          — infolist text entry with avatar + name
 *   - UserStackedEntry   — infolist image entry with stacked avatars
 *   - UserSelect         — form select backed by a user relationship
 *   - UserSelectFilter   — table filter backed by a user relationship
 */

use Livewire\Livewire;
use Zvizvi\UserFields\Tests\Fixtures\Livewire\PostForm;
use Zvizvi\UserFields\Tests\Fixtures\Livewire\PostInfolist;
use Zvizvi\UserFields\Tests\Fixtures\Livewire\PostsFilterTable;
use Zvizvi\UserFields\Tests\Fixtures\Livewire\PostsTable;
use Zvizvi\UserFields\Tests\Fixtures\Livewire\TeamStackedTable;
use Zvizvi\UserFields\Tests\Fixtures\Livewire\UsersTable;
use Zvizvi\UserFields\Tests\Fixtures\Models\Post;
use Zvizvi\UserFields\Tests\Fixtures\Models\Team;
use Zvizvi\UserFields\Tests\Fixtures\Models\User;

beforeEach(function () {
    $this->alice = User::create(['name' => 'Alice', 'email' => 'alice@example.test']);
    $this->bob = User::create(['name' => 'Bob', 'email' => 'bob@example.test']);
});

describe('UserColumn (table)', function () {
    it('renders the author avatar and name for each row', function () {
        $post = Post::create(['title' => 'Hello', 'author_id' => $this->alice->id]);

        Livewire::test(PostsTable::class)
            ->assertOk()
            ->assertCanSeeTableRecords([$post])
            ->assertCanRenderTableColumn('author.name')
            ->assertSee('Alice');
    });

    it('works on the users table itself with make(\'name\')', function () {
        Livewire::test(UsersTable::class)
            ->assertOk()
            ->assertCanSeeTableRecords([$this->alice, $this->bob])
            ->assertCanRenderTableColumn('name')
            ->assertSee('Alice')
            ->assertSee('Bob');
    });
});

describe('UserStackedColumn (table)', function () {
    it('renders stacked avatars for a to-many relationship', function () {
        $team = Team::create(['name' => 'Core']);
        $team->members()->attach([$this->alice->id, $this->bob->id]);

        Livewire::test(TeamStackedTable::class)
            ->assertOk()
            ->assertCanSeeTableRecords([$team])
            ->assertCanRenderTableColumn('members.name')
            // Each avatar's tooltip carries the resolved user's name.
            ->assertSee('Alice')
            ->assertSee('Bob');
    });
});

describe('UserEntry & UserStackedEntry (infolist)', function () {
    it('renders both the text entry and the stacked avatar entry', function () {
        $post = Post::create(['title' => 'Hello', 'author_id' => $this->alice->id]);

        Livewire::test(PostInfolist::class, ['record' => $post])
            ->assertOk()
            ->assertSee('Author')          // UserEntry label
            ->assertSee('Author avatar')   // UserStackedEntry label
            ->assertSee('Alice');          // resolved user name (entry text + tooltip)
    });
});

describe('UserSelect (form)', function () {
    it('preloads user options and updates state on selection', function () {
        $post = Post::create(['title' => 'Hello', 'author_id' => $this->alice->id]);

        Livewire::test(PostForm::class, ['record' => $post])
            ->assertOk()
            ->assertFormFieldExists('author_id')
            ->assertFormSet(['author_id' => $this->alice->id])
            ->assertSee('Alice')
            ->fillForm(['author_id' => $this->bob->id])
            ->assertFormSet(['author_id' => $this->bob->id]);
    });
});

describe('UserSelectFilter (table filter)', function () {
    it('filters the table down to the selected user', function () {
        $postByAlice = Post::create(['title' => 'PA', 'author_id' => $this->alice->id]);
        $postByBob = Post::create(['title' => 'PB', 'author_id' => $this->bob->id]);

        Livewire::test(PostsFilterTable::class)
            ->assertOk()
            ->assertCanSeeTableRecords([$postByAlice, $postByBob])
            ->filterTable('author_id', $this->alice->id)
            ->assertCanSeeTableRecords([$postByAlice])
            ->assertCanNotSeeTableRecords([$postByBob]);
    });
});
