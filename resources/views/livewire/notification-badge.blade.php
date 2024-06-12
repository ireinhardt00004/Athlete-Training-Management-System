<div>
  <!--Counter - Alerts -->
    @if($count > 0)
        <span class="badge badge-danger badge-counter" style="font-size: 15px;">{{ $count }}</span>
    @endif  
    <script>
    document.addEventListener('livewire:load', function () {
        Livewire.hook('message.sent', () => {
            setTimeout(() => {
                Livewire.dispatch('refreshCount');
                 console.log('refreshCount event emitted');
            }, 1000); // Refresh every 2 seconds
        });
    });
</script>
  
</div>

