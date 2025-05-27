<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use MongoDB\Laravel\Eloquent\Model;

class LogEntry extends Model
{
    protected $connection = 'mongodb';

    protected $table = 'base_inertia';

    public $timestamps = false;

    protected $fillable = [
        'system',
        'description',
        'level',
        'type',
        'user',
        'ip',
        'resources',
        'timestamp',
        'data',
        'file',
    ];

    protected $casts = [
        'timestamp' => 'integer',
    ];

    protected string $system = '';

    protected string $description = 'log';

    protected string $level = 'info';

    protected string $type = 'raw';

    protected string $user = '';

    protected ?string $ip = null;

    protected array $resources = [];

    protected array $data = [];

    protected ?string $file = null;

    protected int $timestamp;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->timestamp = time();
        $this->ip = Request::ip();
    }

    public static function make(): static
    {
        return new static;
    }

    // Mutators para garantir o tipo correto
    public function setResourcesAttribute($value)
    {
        $this->attributes['resources'] = $this->ensureArray($value);
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = $this->ensureArray($value);
    }

    public function getResourcesAttribute($value)
    {
        return is_array($value) ? $value : json_decode($value, true);
    }

    public function getDataAttribute($value)
    {
        return is_array($value) ? $value : json_decode($value, true);
    }

    protected function ensureArray($value): array
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }

        return (array) $value;
    }

    // Métodos fluentes
    public function system(string $value): static
    {
        $this->system = $value;

        return $this;
    }

    public function description(string $value): static
    {
        $this->description = $value;

        return $this;
    }

    public function level(string $value): static
    {
        $this->level = strtolower($value);

        return $this;
    }

    public function user(string $value): static
    {
        $this->user = $value;

        return $this;
    }

    public function ip(string $value): static
    {
        $this->ip = $value;

        return $this;
    }

    public function resources(array $value): static
    {
        $this->resources = $value;

        return $this;
    }

    // Métodos para tipos de log
    public function raw(string $message): static
    {
        $this->type = 'raw';
        $this->data = ['message' => $message];

        return $this;
    }

    public function insert(array $after): static
    {
        $this->type = 'insert';
        $this->data = ['after' => $after];

        return $this;
    }

    public function beforeAfter(array $before, array $after): static
    {
        $this->type = 'update';
        $this->data = ['before' => $before, 'after' => $after];

        return $this;
    }

    public function remove(array $before): static
    {
        $this->type = 'delete';
        $this->data = ['before' => $before];

        return $this;
    }

    public function read(array $profiles, string $reason = 'not informed'): static
    {
        $this->type = 'read';
        $this->data = ['profiles' => $profiles, 'reason' => $reason];

        return $this;
    }

    // Método para salvar o log
    public function saveLog(): bool
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1] ?? null;
        $this->file = isset($trace['file']) ? $trace['file'] . ':' . $trace['line'] : null;

        $this->fill([
            'system' => $this->system,
            'description' => $this->description,
            'level' => $this->level,
            'type' => $this->type,
            'user' => $this->user,
            'ip' => $this->ip,
            'resources' => $this->resources,
            'timestamp' => $this->timestamp,
            'data' => $this->data,
            'file' => $this->file,
        ]);

        // Forçar a conversão para array antes de salvar
        $this->attributes['resources'] = $this->ensureArray($this->resources);
        $this->attributes['data'] = $this->ensureArray($this->data);

        return $this->save();
    }

    // Método alternativo caso ainda persista o problema
    public function saveDirectly(): bool
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1] ?? null;
        $this->file = isset($trace['file']) ? $trace['file'] . ':' . $trace['line'] : null;

        return DB::connection('mongodb')
            ->collection($this->table)
            ->insert([
                'system' => $this->system,
                'description' => $this->description,
                'level' => $this->level,
                'type' => $this->type,
                'user' => $this->user,
                'ip' => $this->ip,
                'resources' => $this->ensureArray($this->resources),
                'timestamp' => $this->timestamp,
                'data' => $this->ensureArray($this->data),
                'file' => $this->file,
            ]);
    }
}
