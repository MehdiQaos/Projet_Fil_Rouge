<x-menu.layout>
        <x-menu.sidebar/>
    <div id="page-content-wrapper">
        <x-menu.navbar/>
        <div class="card mx-5 mt-5 p-5">
            <h3 class="text-center text-muted">Update Profile</h3>
            <form  method="POST" action="/users/profile" class="container">
                @csrf
                <input type="text" name="id" value="{{ auth()->user()->id }}" hidden/>
                <div class="row form-outline my-3 gap-1">
                    <input value="{{ auth()->user()->first_name }}" type="text" class="col form-control" placeholder="First name" name="first_name" autofocus/>
                    <input value="{{ auth()->user()->last_name }}" type="text" class="col form-control" placeholder="Last name" name="last_name"/>
                    @error('first_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    @error('last_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row form-outline my-3">
                    <input value="{{ auth()->user()->user_name }}" type="text" class="form-control" placeholder="User name" name="user_name"/>
                    @error('user_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row form-outline my-3">
                    <input value="{{ auth()->user()->email }}" type="email" id="email-input" class="form-control" placeholder="Email" name="email"/>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row d-flex justify-content-center text-center">
                    <button type="submit" id="update-button" class="btn btn-outline-success p-2 mt-2 w-25" name="changeuserinfo"><span class="fw-bold">Update</span></button>
                </div>
            </form>
        </div>
        <div class="card mx-5 mb-5 mt-3 p-5">
            <h3 class="text-center text-muted">Change Password</h3>
            <form  method="POST" action="/users/password" class="container">
                @csrf
                <div class="row form-outline my-3">
                    <input type="password" class="form-control" placeholder="New password" name="password"/>
                </div>
                <div class="row form-outline my-3">
                    <input type="password" class="form-control" placeholder="Repeat password" name="password_confirmation"/>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row d-flex justify-content-center text-center">
                    <button type="submit" class="btn btn-danger p-2 mt-2 w-25"><span class="fw-bold">Change</span></button>
                </div>
            </form>
        </div>
    </div>
</x-menu.layout>