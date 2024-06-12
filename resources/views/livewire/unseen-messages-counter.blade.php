<!-- resources/views/livewire/unseen-messages-counter.blade.php -->
<div> 
@if($count > 0)
        <span class="badge badge-danger badge-counter">{{ $count }}</span>
    @endif 
</div>
