<?php

namespace Zvizvi\UserFields\Components\Concerns;

use Illuminate\Database\Eloquent\Model;

trait CanResolveUser
{
    /**
     * Replace attribute-value state (from dot notation like `teamMembers.name`)
     * with the related user models before rendering, so each list item shows
     * the correct avatar even when two users share the same display value.
     */
    public function getState(): mixed
    {
        return $this->resolveUsersInState(parent::getState());
    }

    protected function resolveUsersInState(mixed $state): mixed
    {
        if (blank($state) || $state instanceof Model) {
            return $state;
        }

        if (is_iterable($state) && collect($state)->contains(fn ($item) => $item instanceof Model)) {
            return $state;
        }

        $record = $this->getRecord();

        if (! $record instanceof Model || ! $this->userStateHasRelationship($record)) {
            return $state;
        }

        $results = $this->getUserStateRelationshipResults($record);

        if (empty($results)) {
            return $state;
        }

        if ($this->isDistinctList()) {
            $results = collect($results)->unique(fn (Model $user) => $user->getKey())->values()->all();
        }

        return is_iterable($state) ? $results : $results[0];
    }

    /**
     * Resolve the user model to display from the cell state.
     *
     * Supports three naming patterns:
     * - `make('author')` — the state is the related user model itself.
     * - `make('author.name')` — the state is an attribute of the related user,
     *   so native searching and sorting work; the model is resolved from the record.
     * - `make('name')` on the users table itself — the record is the user.
     */
    protected function resolveUserFromState(mixed $state, mixed $record): ?Model
    {
        if ($state instanceof Model) {
            return $state;
        }

        if (! $record instanceof Model) {
            return null;
        }

        if ($this->userStateHasRelationship($record)) {
            $results = $this->getUserStateRelationshipResults($record);

            if (count($results) === 1) {
                return $results[0];
            }

            $attribute = $this->getUserStateAttributeName($record);

            foreach ($results as $result) {
                if (data_get($result, $attribute) === $state) {
                    return $result;
                }
            }

            return null;
        }

        if ($record->hasAttribute($this->getName())) {
            return $record;
        }

        return null;
    }

    /**
     * Table columns resolve relationships via `HasCellState`, while schema
     * entries use `CanGetStateFromRelationships` — same logic, different names.
     */
    protected function userStateHasRelationship(Model $record): bool
    {
        $method = method_exists($this, 'hasRelationship') ? 'hasRelationship' : 'hasStateRelationship';

        return $this->{$method}($record);
    }

    /**
     * @return array<Model>
     */
    protected function getUserStateRelationshipResults(Model $record): array
    {
        $method = method_exists($this, 'getRelationshipResults') ? 'getRelationshipResults' : 'getStateRelationshipResults';

        return $this->{$method}($record);
    }

    protected function getUserStateAttributeName(Model $record): string
    {
        if (method_exists($this, 'getAttributeName')) {
            $method = 'getAttributeName';

            return $this->{$method}($record);
        }

        $method = 'getStateRelationshipAttribute';

        return $this->{$method}();
    }
}
