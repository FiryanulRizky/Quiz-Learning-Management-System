@extends('layouts.admin')


@section("content")


<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4 border-bottom-primary">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">{{ __("Form Sub Materi") }}</h6>
                <div class="dropdown no-arrow">
                    <x-BackButton />
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                
                <div class="text-center">

               
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input name="title" type="text" class="form-control"  disabled
                                value="{{ $term->title ?? '' }}">   
                        </div>
                        <div class="col-sm-6">
                            <input name="image" type="text" class="form-control" disabled 
                                placeholder="Gambar" value="{{ $term->image ?? '' }}">
                        </div>
                    </div>
                    
                    
                    @livewire('forms.department-course-drop-down', [
                        'department_id' => $term->department_id ?? null ,
                        'course_id' => $term->course_id ?? null
                    ])
                
                
                    <div class="form-group">
                        <textarea name="description" class="form-control" disabled
                            placeholder="Deskripsi">{{ $term->description ?? '' }}</textarea>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <ul class="nav nav-tabs" data-tabs="tabs">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#RoadMap">Kurikulum</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Particpants">Peserta</a></li>
        </ul>
        
        
        
        <div class="tab-content">
            <div class="tab-pane fade show active" id="RoadMap">
                @include('contents.admin.term.parts.roadmap')
            </div>
            <div class="tab-pane" id="Particpants">
                @include('contents.admin.term.parts.participants')
            </div>
            
        </div>
    </div>
</div>







@endsection


