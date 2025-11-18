@extends('backend.layouts.app')

@section('title')
    Afrojee | Send Email
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 afrojee-spaceout afrojee-row">
                        <h6 class="text-white text-capitalize ps-3">Send Email</h6>
                    </div>
                </div>
                <div class="card-body px-4 pb-2">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.email.send') }}" method="POST" class="mt-4">
                        @csrf

                        <div class="mb-3">
                            <label for="to" class="form-label">Recipient Email <span class="text-danger">*</span></label>
                            <input type="email" 
                                   class="form-control @error('to') is-invalid @enderror" 
                                   id="to" 
                                   name="to" 
                                   value="{{ old('to') }}" 
                                   placeholder="customer@example.com"
                                   required>
                            @error('to')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="recipient_name" class="form-label">Recipient Name</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="recipient_name" 
                                   name="recipient_name" 
                                   value="{{ old('recipient_name') }}" 
                                   placeholder="Customer Name">
                            <small class="form-text text-muted">Optional - defaults to "Valued Customer" if left empty</small>
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Email Subject <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('subject') is-invalid @enderror" 
                                   id="subject" 
                                   name="subject" 
                                   value="{{ old('subject') }}" 
                                   placeholder="Your email subject here"
                                   required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Email Message <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      id="message" 
                                      name="message" 
                                      rows="10" 
                                      placeholder="Type your message here..."
                                      required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Line breaks will be preserved in the email</small>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-dark">
                                <i class="material-symbols-rounded me-2" style="vertical-align: middle; font-size: 18px;">send</i>
                                Send Email
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

