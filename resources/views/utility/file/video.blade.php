<div class="text-center">
    <h3 class="p-4">{{ __('deskripsi: ') }} {{ $file->description }}</h3>
    <hr/>
    <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item p-4" src="{{ asset('storage/'.$file->file) }}" allowfullscreen></iframe>
    </div>
</div>