<div class="text-center">
    <h3>{{ __('deskripsi: ') }} {{ $file->description }}</h3>
    <hr />

    <audio controls>
        <source src="{{ asset('storage/'.$file->file) }}" type="audio/mpeg">
        Browser Anda tidak mendukung file audio.
    </audio>
    
</div>