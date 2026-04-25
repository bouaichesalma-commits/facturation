<div>
    <a href="#" class="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <main rel="main" class="mainNotifcation ">
            <div class="notification">
                <svg viewbox="0 0 166 197">
                    <path
                        d="M82.8652955,196.898522 C97.8853137,196.898522 110.154225,184.733014 110.154225,169.792619 L55.4909279,169.792619 C55.4909279,184.733014 67.8452774,196.898522 82.8652955,196.898522 L82.8652955,196.898522 Z"
                        class="notification--bellClapper"></path>
                    <path
                        d="M146.189736,135.093562 L146.189736,82.040478 C146.189736,52.1121695 125.723173,27.9861651 97.4598237,21.2550099 L97.4598237,14.4635396 C97.4598237,6.74321823 90.6498186,0 82.8530327,0 C75.0440643,0 68.2462416,6.74321823 68.2462416,14.4635396 L68.2462416,21.2550099 C39.9707102,27.9861651 19.5163297,52.1121695 19.5163297,82.040478 L19.5163297,135.093562 L0,154.418491 L0,164.080956 L165.706065,164.080956 L165.706065,154.418491 L146.189736,135.093562 Z"
                        class="notification--bell"></path>
                </svg>
                <span class="notification--num">{{ $countExprisation }}</span>
            </div>

        </main>

    </a>


    <div class="dropdown-menu scroolbar-dropdown-menu  notification-dropDown text-end shadow ps-2 py-2 mb-5  he-100"
        role="menu">
        <div class="dropdown-header">
            <div class="row justify-content-between">
                <div class="col-1 px-4 font-w">Notifications </div>
                <div class="col-6" id="allRead">

                    <a href="#" class="text-decoration-none font-w" wire:click="removeNotification">Mark All As
                        Read</a>
                </div>
            </div>
        </div>

        @forelse ($ClientWithDateExpiration as $clients)
            <div class="cardsNot bg-light border-bottom tooltip-container my-3">
                <div class="img"><i class="bi bi-clock-history text-white px-1"></i></div>
                <div class="textBox">
                    <div class="textContent">
                        <p class="h1">Date Expiration</p>
                        <span class="span">12 min ago </span> 
                        <span class="span">{{ $clients->DateExpiration }}</span>
                    </div>
                    <p class="p">La validité de l'hébergement du site du client <span
                            class="badge text-black ">{{ $clients->nom }}</span> a expiré.
                    </p>
                    <div>
                    </div>
                </div>

                <span class="tooltip">N° ICE : {{ $clients->ice }}</span>
            </div>

        @empty

            <div class="cardsNot bg-none border-bottom  my-3 d-flex justify-content-center">
                No notifications
            </div>

    </div>
    @endforelse
    
</div> 
{{-- <script>
    // let client = @json($client);
    // if (client) {
    //     // alert(client.nom)
    //     console.log(client);
    // }
</script> --}}

