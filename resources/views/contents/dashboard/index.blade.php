@extends('layouts.admin')


@section("content")



<div>
    @can('course.index')
    <li class="nav-item" style="list-style-type: none;">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#ModulCollapse" aria-expanded="true" aria-controls="ACLCollapse">
            <div class="card">
                <div class="card-header">
                    <h3>@lang('Kelola Modul')</h3>
                </div>
            </div>
        </a>

        <div id="ModulCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="py-2 collapse-inner rounded">
                <div class="row mt-4 mb-4 justify-content-center">

                    <div class="col-2">
                        <div class="card border-left-primary shadow">
                            <div class="card-body">
                                <a href="{{ route('department.index') }}">
                                    <img class="card-img-top" src="{{ asset('img/admin/menu/department.jpg') }}" alt="{{ __('Department') }}">
                                </a>
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{ route('department.index') }}" class="font-weight-bold text-gray-800 text-uppercase">
                                    {{ __('Departemen') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="card border-left-primary shadow">
                            <div class="card-body">
                                <a href="{{ route('course.index') }}">
                                    <img class="card-img-top" src="{{ asset('img/admin/menu/course.jpg') }}" alt="{{ __('Course') }}">
                                </a>
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{ route('course.index') }}" class="font-weight-bold text-gray-800 text-uppercase">
                                    {{ __('Modul') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="card border-left-primary shadow">
                            <div class="card-body">
                                <a href="{{ route('term.index') }}">
                                    <img class="card-img-top" src="{{ asset('img/admin/menu/term.jpg') }}" alt="{{ __('terms') }}">
                                </a>
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{ route('term.index') }}" class="font-weight-bold text-gray-800 text-uppercase">
                                    {{ __('Sub Materi') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="card border-left-primary shadow">
                            <div class="card-body">
                                <a href="{{ route('session.index') }}">
                                    <img class="card-img-top" src="{{ asset('img/admin/menu/session.jpg') }}" alt="{{ __('Sessions') }}">
                                </a>
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{ route('session.index') }}" class="font-weight-bold text-gray-800 text-uppercase">
                                    {{ __('Sesi Modul') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>

    <li class="nav-item" style="list-style-type: none;">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#QuizCollapse" aria-expanded="true" aria-controls="ACLCollapse">
            <div class="card">
                <div class="card-header">
                    <h3>@lang('Kelola Quiz dan Ujian')</h3>
                </div>
            </div>
        </a>
        
        <div id="QuizCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="py-2 collapse-inner rounded">
                <div class="row mt-4 mb-4 justify-content-center">
                    <div class="col-2">
                        <div class="card border-left-primary shadow">
                            <div class="card-body">
                                <a href="{{ route('quiz.index') }}">
                                    <img class="card-img-top" src="{{ asset('img/admin/menu/quiz.png') }}" alt="{{ __('Quiz') }}">
                                </a>
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{ route('quiz.index') }}" class="font-weight-bold text-gray-800 text-uppercase">
                                    {{ __('Quiz') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="card border-left-primary shadow">
                            <div class="card-body">
                                <a href="{{ route('question.index') }}">
                                    <img class="card-img-top" src="{{ asset('img/admin/menu/question.png') }}" alt="{{ __('Question') }}">
                                </a>
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{ route('question.index') }}" class="font-weight-bold text-gray-800 text-uppercase">
                                    {{ __('Pertanyaan') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>

    <li class="nav-item" style="list-style-type: none;">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#QuizTypeCollapse" aria-expanded="true" aria-controls="ACLCollapse">
            <div class="card">
                <div class="card-header">
                    <h3>@lang('Kelola Jenis Isian Quiz')</h3>
                </div>
            </div>
        </a>
    @endcan
    <div id="QuizTypeCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="py-2 collapse-inner rounded">
            <div class="row  mt-4 mb-4 justify-content-center">
                @can('rubric.index')
                <div class="col-2">

                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('rubric.index') }}">
                                <img class="card-img-top img-circle" src="{{ asset('img/admin/menu/rubric.png') }}" alt="{{ __('rubric') }}">
                            </a>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('rubric.index') }}" class="font-weight-bold text-gray-800 text-uppercase">
                                {{ __('rubrik') }}
                            </a>
                        </div>

                    </div>

                </div>
                @endcan

                @can('feedback.index')
                <div class="col-2">

                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('feedback.index') }}">
                                <img class="card-img-top img-circle" src="{{ asset('img/admin/menu/feedback.png') }}" alt="{{ __('feedback') }}">
                            </a>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('feedback.index') }}" class="font-weight-bold text-gray-800 text-uppercase">
                                {{ __('benar salah') }}
                            </a>
                        </div>

                    </div>
                </div>
                @endcan
                @can('file.index')
                <div class="col-2">

                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('file.index') }}">
                                <img class="card-img-top img-circle" src="{{ asset('img/admin/menu/file.png') }}" alt="{{ __('file') }}">
                            </a>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('file.index') }}" class="font-weight-bold text-gray-800 text-uppercase">
                                {{ __('File') }}
                            </a>
                        </div>
                    </div>

                </div>
                @endcan

                @can('document.index')
                <div class="col-2">

                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('document.index') }}">
                                <img class="card-img-top img-circle" src="{{ asset('img/admin/menu/document.png') }}" alt="{{ __('Dokumen') }}">
                            </a>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('document.index') }}" class="font-weight-bold text-gray-800 text-uppercase">
                                {{ __('dokumen') }}
                            </a>
                        </div>
                    </div>

                </div>
                @endcan
                </div>
            </div>
        </div>
    </li>
    
    @can('badges.index')
    <li class="nav-item" style="list-style-type: none;">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#PenghargaanCollapse" aria-expanded="true" aria-controls="ACLCollapse">
            <div class="card">
                <div class="card-header">
                    <h3>@lang('Kelola Penghargaan')</h3>
                </div>
            </div>
        </a>
    @endcan
    <div id="PenghargaanCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="py-2 collapse-inner rounded">
            <div class="row  mt-4 mb-4 justify-content-center">
                @can('badges.index')
                <div class="col-2">

                    <div class="card">
                        <div class="card-body">

                            <a href="{{ route('badges.index') }}">
                                <img class="card-img-top img-circle" src="{{ asset('img/admin/menu/badge.png') }}" alt="{{ __('badges') }}">
                            </a>

                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('badges.index') }}" class="font-weight-bold text-gray-800 text-uppercase">
                                {{ __('penghargaan') }}
                            </a>
                        </div>
                    </div>
                </div>
                @endcan
                </div>
            </div>
        </div>
    </li>
</div>

<hr>

<div class="row">
    <div class="col-4">
        <x-box.profile-box :user="$user" />
    </div>
    <div class="col-4">
        <x-box.coins.user-coins :user="$user" />
    </div>
    <div class="col-4">
        <x-box.leader-board.top-learner-score :user="$user" />
    </div>
</div>
@endsection