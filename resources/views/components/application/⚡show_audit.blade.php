<?php

use Livewire\Component;
use OwenIt\Auditing\Models\Audit;

new class extends Component {
    public string $model;

    public int $model_id;

    public function mount(string $model, int $model_id)
    {
        $this->model = "App\\Models\\" . $model;
        $this->model_id = $model_id;
    }

    public function audits()
    {
        return Audit::query()->with('user')->where('auditable_type', $this->model)->where('auditable_id', $this->model_id)->latest()->get();
    }

    public function formatValue(mixed $value): string
    {
        return match (true) {
            is_null($value) => '—',
            is_bool($value) => $value ? 'Yes' : 'No',
            is_array($value) => json_encode($value),
            default => (string) $value
        };
    }
};
?>

@php
    $audits = $this->audits();
@endphp

<div>
    <x-flowbite.card>
        <x-slot:header>
            <x-flowbite.card-header title="Audit trail"
                subtitle="Track system activities, monitor record changes, and review audit logs." />
        </x-slot:header>

        <x-flowbite.card-body>
            @if ($audits->isEmpty())
                <x-flowbite.empty-state title="No activity yet"
                    description="Changes to this record — and who made them — will appear here." class="p-0" />
            @else
                <ol class="space-y-0">
                    @foreach ($audits as $audit)
                        @php
                            $event = (string) $audit->event;

                            $meta = match ($event) {
                                'created' => [
                                    'label' => 'Created',
                                    'variant' => 'success',
                                    'marker' => 'bg-success-soft text-fg-success'
                                ],
                                'updated' => [
                                    'label' => 'Updated',
                                    'variant' => 'primary',
                                    'marker' => 'bg-neutral-tertiary-soft text-heading'
                                ],
                                'deleted' => [
                                    'label' => 'Deleted',
                                    'variant' => 'danger',
                                    'marker' => 'bg-danger-soft text-fg-danger'
                                ],
                                'restored' => [
                                    'label' => 'Restored',
                                    'variant' => 'warning',
                                    'marker' => 'bg-warning-soft text-fg-warning'
                                ],
                                default => [
                                    'label' => ucfirst($event),
                                    'variant' => 'neutral',
                                    'marker' => 'bg-neutral-tertiary-soft text-body-subtle'
                                ]
                            };

                            $actor = $audit->user;
                            $changes = collect($audit->getModified())->except(['id'])->all();
                        @endphp

                        <li wire:key="audit-{{ $audit->id }}" class="relative flex gap-4">
                            <div class="flex flex-col items-center">
                                <span
                                    class="flex size-9 shrink-0 items-center justify-center rounded-full {{ $meta['marker'] }}">
                                    @switch($event)
                                        @case('created')
                                            <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path
                                                    d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                            </svg>
                                        @break

                                        @case('updated')
                                            <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path
                                                    d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                                                <path
                                                    d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z" />
                                            </svg>
                                        @break

                                        @case('deleted')
                                            <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @break

                                        @case('restored')
                                            <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M7.793 2.232a.75.75 0 0 1-.025 1.06L3.622 7.25h10.003a5.375 5.375 0 0 1 0 10.75H10.75a.75.75 0 0 1 0-1.5h2.875a3.875 3.875 0 0 0 0-7.75H3.622l4.146 3.957a.75.75 0 0 1-1.036 1.085l-5.5-5.25a.75.75 0 0 1 0-1.085l5.5-5.25a.75.75 0 0 1 1.06.025Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @break

                                        @default
                                            <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                    @endswitch
                                </span>

                                @unless ($loop->last)
                                    <span class="mt-1 w-px grow bg-bento-border" aria-hidden="true"></span>
                                @endunless
                            </div>

                            <div class="{{ $loop->last ? '' : 'pb-8' }} min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <x-flowbite.badge :variant="$meta['variant']">{{ $meta['label'] }}</x-flowbite.badge>

                                    <time class="text-xs text-body-subtle"
                                        datetime="{{ $audit->created_at?->toIso8601String() }}">
                                        {{ $audit->created_at?->format('M j, Y g:i A') }}
                                        <span aria-hidden="true">·</span>
                                        {{ $audit->created_at?->diffForHumans() }}
                                    </time>
                                </div>

                                {{-- Who triggered the event --}}
                                <div class="mt-2 flex items-center gap-2">
                                    <x-flowbite.avatar :name="$actor?->name ?? 'System'" size="xs" />

                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-medium text-heading">
                                            {{ $actor?->name ?? 'System' }}
                                        </p>

                                        <p class="truncate text-xs text-body-subtle">
                                            @if ($actor)
                                                {{ $actor->email }}
                                                @if (filled($audit->ip_address))
                                                    <span aria-hidden="true">·</span> {{ $audit->ip_address }}
                                                @endif
                                            @else
                                                Automated process
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                {{-- Changed attributes --}}
                                @if (!empty($changes))
                                    <ul
                                        class="mt-3 space-y-1.5 rounded-base border border-bento-border bg-bento-canvas p-3">
                                        @foreach ($changes as $attribute => $change)
                                            @php
                                                $hasOld = array_key_exists('old', $change);
                                                $hasNew = array_key_exists('new', $change);
                                            @endphp

                                            <li class="flex flex-wrap items-baseline gap-x-2 gap-y-0.5 text-xs">
                                                <span class="font-medium uppercase tracking-wide text-heading">
                                                    {{ \Illuminate\Support\Str::headline($attribute) }}
                                                </span>

                                                @if ($hasOld)
                                                    <span class="text-body-subtle {{ $hasNew ? 'line-through' : '' }}">
                                                        {{ $this->formatValue($change['old']) }}
                                                    </span>
                                                @endif

                                                @if ($hasOld && $hasNew)
                                                    <span class="text-body-subtle" aria-hidden="true">&rarr;</span>
                                                @endif

                                                @if ($hasNew)
                                                    <span
                                                        class="text-body">{{ $this->formatValue($change['new']) }}</span>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ol>
            @endif
        </x-flowbite.card-body>
    </x-flowbite.card>
</div>
