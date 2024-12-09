<div class="col-12 text-left mt-4 p-4">

    <div class="card shadow p-2">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">soal pencocokan:</h6>
        </div>
        <div class="card-body">

            <input type="hidden" wire:model="questionTypeId" />
            <div class="form-group">
                <label for="titleofquestion">judul soal</label>
                <input type="text" class="form-control" id="titleofquestion" wire:model="title">
            </div>
            <div class="form-group">
                <label for="descriptionofquestion">deskripsi soal</label>
                <textarea class="form-control" id="descriptionofquestion" wire:model="question_body"></textarea>
            </div>
            @forelse($answers as $index => $answer)
            <div class="form-group">
            
            <div class="row align-items-end">
                <div class="col-5">
                    <label for="answer{{ $index }}.left">Pernyataan {{ $loop->iteration }}</label>
                    <input type="text" class="form-control" id="answer{{ $index }}.left" wire:model="answers.{{ $index }}.left">
                </div>
                <div class="col-5">
                    <label for="answer{{ $index }}.right">jawaban {{ $loop->iteration }}</label>
                    <input type="text" class="form-control" id="answer{{ $index }}.right" wire:model="answers.{{ $index }}.right">
                </div>
                <div class="col-2">
                    <button id="delete{{ $index }}" class="btn btn-sm btn-danger btn-circle" wire:click.prevent="removeAnswer('{{ $index }}')"><i class="fa fa-times"></i></button>
                </div>
            </div>
            </div>
            @empty 
            @endforelse
            
            

            <button wire:click.prevent="addNewAnswer" class="btn btn-success btn-icon-split float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
            </button>
            
            </form>

        </div>
        <div class="card-footer">
            <button wire:click.prevent="store" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Simpan</span>
            </button>
        </div>
    </div>
    <form>
    


    @include('livewire.factory.question.matching-case-question.review')
</div>