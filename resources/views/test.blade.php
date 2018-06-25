@foreach ($data as $task)
    {{ $task->clients->id }}
@endforeach