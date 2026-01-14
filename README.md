# Filament User Fields

A comprehensive Filament v4 plugin that provides ready-to-use user field components with avatar display for forms, tables, infolists, and filters. This package simplifies the display of user information across your Filament application by providing pre-configured components that automatically render user avatars and names in a consistent, professional manner.

---

## Features

-  **Pre-styled Components**: Beautiful user display with avatars and names out of the box
-  **Multiple Display Types**: Support for tables, infolists, forms, and filters
-  **Stacked Avatars**: Display multiple users in a compact, stacked format
-  **Easy Integration**: Drop-in replacement for standard Filament components
-  **Consistent UI**: Unified user representation across your entire application
-  **Zero Configuration**: Works immediately with Filament's default user avatar system

---

## Installation

Install the package via composer:

```bash
composer require zvizvi/user-fields
```

That's it! The package will automatically register itself with Laravel and Filament.

---

## Available Components

This package provides six main components, each designed for specific use cases within Filament:

<img width="598" height="275" alt="image" src="https://github.com/user-attachments/assets/2811689a-4ba2-4f09-b30f-cad351890ef2" />


### 1. UserColumn (Tables)

**Purpose**: Display user information in table columns with avatar and name.

**Use Case**: Lists, resource tables, relation managers

**Example**:
```php
use Zvizvi\UserFields\Components\UserColumn;

public static function table(Table $table): Table
{
    return $table
        ->columns([
            UserColumn::make('author')
                ->label('Author'),
            
            UserColumn::make('assigned_to')
                ->label('Assigned To')
                ->wrapped(), // Display in column layout
        ]);
}
```

**Features**:
- Displays user avatar (circular) with name
- Optional `wrapped()` method for vertical layout
- Supports single users or collections
- Automatic line breaks for multiple users

---

<img width="485" height="146" alt="image" src="https://github.com/user-attachments/assets/39e7e50e-f04d-498d-991b-172d3289d2c0" />

### 2. UserEntry (Infolists)

**Purpose**: Display user information in infolists/view pages.

**Use Case**: Resource view pages, modal details, info panels

**Example**:
```php
use Zvizvi\UserFields\Components\UserEntry;

public static function infolist(Infolist $infolist): Infolist
{
    return $infolist
        ->schema([
            UserEntry::make('created_by')
                ->label('Created By'),
            
            UserEntry::make('reviewers')
                ->label('Reviewers')
                ->wrapped(), // Display in column layout
        ]);
}
```

**Features**:
- Read-only display of user information
- Consistent styling with UserColumn
- Supports single or multiple users
- Optional wrapped layout

---

<img width="769" height="333" alt="image" src="https://github.com/user-attachments/assets/973b50d1-8469-4325-b1b8-b9fbdb2ac13a" />

<img width="769" height="333" alt="image" src="https://github.com/user-attachments/assets/7375a233-71cb-48fa-bbcf-5d1927afcc0f" />

### 3. UserSelect (Forms)

**Purpose**: Select field for choosing users with rich display.

**Use Case**: Forms, create/edit pages, modals

**Example**:
```php
use Zvizvi\UserFields\Components\UserSelect;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            UserSelect::make('user_id')
                ->label('Select User')
                ->relationship('user', 'name')
                ->searchable()
                ->preload(),
            
            UserSelect::make('team_members')
                ->label('Team Members')
                ->relationship('teamMembers', 'name')
                ->multiple()
                ->searchable(),
        ]);
}
```

**Features**:
- Rich dropdown with user avatars
- HTML rendering support for avatars
- Works with relationships
- Searchable and preloadable
- Supports multiple selection

---

<img width="446" height="310" alt="image" src="https://github.com/user-attachments/assets/06db5b36-84ba-4761-8be7-00298521c196" />

### 4. UserSelectFilter (Table Filters)

**Purpose**: Filter table data by user selection.

**Use Case**: Table filters and advanced filtering; only works with relationship-based filtering.

**Example**:
```php
use Zvizvi\UserFields\Components\UserSelectFilter;

public static function table(Table $table): Table
{
    return $table
        ->filters([
            UserSelectFilter::make('author_id')
                ->label('Author')
                ->relationship('author', 'name')
                ->searchable()
                ->preload(),
            
            UserSelectFilter::make('assigned_to')
                ->label('Assigned To')
                ->relationship('assignedUser', 'name')
                ->multiple(),
        ]);
}
```

**Features**:
- Filter results by user
- Rich display with avatars in dropdown
- Supports single or multiple selection
- Searchable options

---

<img width="498" height="263" alt="image" src="https://github.com/user-attachments/assets/f142df48-7789-4036-b1bf-4d06786fe9d5" />

### 5. UserStackedColumn (Tables - Multiple Users)

**Purpose**: Display multiple users as stacked circular avatars in tables.

**Use Case**: Team members, collaborators, participants in compact space

**Example**:
```php
use Zvizvi\UserFields\Components\UserStackedColumn;

public static function table(Table $table): Table
{
    return $table
        ->columns([
            UserStackedColumn::make('team_members')
                ->label('Team')
                ->ring(2) // Ring width around avatars
                ->imageHeight(32), // Avatar size
            
            UserStackedColumn::make('collaborators')
                ->label('Collaborators')
                ->tooltip(fn ($state) => $state?->name), // Hover tooltip
        ]);
}
```

**Features**:
- Compact stacked avatar display
- Circular avatars with ring borders
- Hover tooltips showing user names
- Customizable size and ring width
- Ideal for displaying multiple users in limited space

---

<img width="458" height="125" alt="image" src="https://github.com/user-attachments/assets/3f577480-60c4-40f6-8c95-521b63ece06a" />

### 6. UserStackedEntry (Infolists - Multiple Users)

**Purpose**: Display multiple users as stacked avatars in infolists.

**Use Case**: View pages showing team members, collaborators, participants

**Example**:
```php
use Zvizvi\UserFields\Components\UserStackedEntry;

public static function infolist(Infolist $infolist): Infolist
{
    return $infolist
        ->schema([
            UserStackedEntry::make('project_members')
                ->label('Project Team')
                ->ring(2)
                ->imageHeight(32),
            
            UserStackedEntry::make('reviewers')
                ->label('Code Reviewers'),
        ]);
}
```

**Features**:
- Same styling as UserStackedColumn
- Read-only display
- Stacked circular avatars
- Tooltips on hover
- Perfect for displaying multiple users in view mode

---

## Component Comparison

| Component | Context | Display Type | User Count | Interactive |
|-----------|---------|--------------|------------|-------------|
| **UserColumn** | Tables | Avatar + Name | Single/Multiple | Read-only |
| **UserEntry** | Infolists | Avatar + Name | Single/Multiple | Read-only |
| **UserSelect** | Forms | Dropdown with Avatar | Single/Multiple | Interactive |
| **UserSelectFilter** | Filters | Dropdown with Avatar | Single/Multiple | Interactive |
| **UserStackedColumn** | Tables | Stacked Avatars | Multiple | Read-only |
| **UserStackedEntry** | Infolists | Stacked Avatars | Multiple | Read-only |

---

## Advanced Usage

### Customizing Avatar Display

All components use Filament's built-in avatar system. To customize avatars globally:

```php
// In your User model
public function getFilamentAvatarUrl(): ?string
{
    return $this->avatar_url 
        ? Storage::url($this->avatar_url)
        : "https://ui-avatars.com/api/?name={$this->name}&color=7F9CF5&background=EBF4FF";
}
```

### Working with Relationships

```php
UserColumn::make('author')
    ->relationship('author', 'name') // Define relationship
    ->label('Written By'),

UserSelect::make('reviewer_id')
    ->relationship('reviewer', 'name')
    ->searchable(['name', 'email']) // Search multiple fields
    ->preload(),
```

### Handling Multiple Users

```php
// In your model
public function teamMembers()
{
    return $this->belongsToMany(User::class, 'team_user');
}

// In your resource
UserColumn::make('teamMembers')
    ->label('Team')
    ->wrapped(), // Display in vertical layout

// Or use stacked for compact display
UserStackedColumn::make('teamMembers')
    ->label('Team'),
```

### Custom Styling

```php
UserColumn::make('author')
    ->extraAttributes([
        'class' => 'custom-user-display'
    ]),

UserStackedColumn::make('team')
    ->ring(3) // Thicker ring
    ->imageHeight(40), // Larger avatars
```

---

## Real-World Examples

### Blog Post Resource

```php
use Zvizvi\UserFields\Components\{UserColumn, UserSelect, UserSelectFilter};

class PostResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('title')->required(),
            UserSelect::make('author_id')
                ->label('Author')
                ->relationship('author', 'name')
                ->default(auth()->id())
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                UserColumn::make('author')->label('Author'),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                UserSelectFilter::make('author_id')
                    ->label('Filter by Author')
                    ->relationship('author', 'name'),
            ]);
    }
}
```

### Project Management Resource

```php
use Zvizvi\UserFields\Components\{UserStackedColumn, UserSelect, UserEntry};

class ProjectResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->required(),
            UserSelect::make('owner_id')
                ->label('Project Owner')
                ->relationship('owner', 'name')
                ->required(),
            UserSelect::make('team_members')
                ->label('Team Members')
                ->relationship('teamMembers', 'name')
                ->multiple()
                ->searchable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name'),
            UserColumn::make('owner')->label('Owner'),
            UserStackedColumn::make('teamMembers')
                ->label('Team')
                ->ring(2),
        ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            TextEntry::make('name'),
            UserEntry::make('owner')->label('Project Owner'),
            UserStackedEntry::make('teamMembers')
                ->label('Team Members'),
        ]);
    }
}
```

---

## Requirements

- PHP 8.2 or higher
- Laravel 10.x or 11.x
- Filament 4.x

---

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

---

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

---

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

---

## Credits

- [zvizvi](https://github.com/zvizvi)
- [All Contributors](../../contributors)

---

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
