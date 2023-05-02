<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
<x-menu.layout>
        <x-menu.sidebar/>
    <div id="page-content-wrapper">
        <x-menu.navbar/>
<section class="content_section">
    <div class="row m-4"> <!-- remove row from divs? -->
        <button class="p-3 shadow-sm d-flex bg-light justify-content-start align-items-center rounded border">
            <i class="uil uil-medkit fs-3 mycolor box rounded py-4 px-4 my-2 mx-4"></i>
            <div class="text-start">
                <h3 class="fs-2 mycolor">Account Settings</h3>
                <p class="fs-6 text-black mb-0">Edit your Account Details & Change Password</p>
            </div>
        </button>
    </div>

    <div class="row m-4">
        <button class="p-3 shadow-sm d-flex bg-light justify-content-start align-items-center rounded border">
            <i class="uil uil-eye fs-3 mycolor box rounded py-4 px-4 my-2 mx-4"></i>
            <div class="text-start">
                <h3 class="fs-2 mycolor">View Account Details</h3>
                <p class="fs-6 text-black mb-0">View Personal information About Your Accout</p>
            </div>
        </button>
    </div>

    <div class="row m-4">
        <button class="p-3 shadow-sm d-flex bg-light justify-content-start align-items-center rounded border">
            <i class="uil uil-accessible-icon-alt fs-3 box text-danger rounded py-4 px-4 my-2 mx-4"></i>
            <div class="text-start">
                <h3 class="fs-2 text-danger">Delete Account</h3>
                <p class="fs-6 text-black mb-0">Will Permanently Remove your Account</p>
            </div>
        </button>
    </div>
</section>
    </div>
</x-menu.layout>