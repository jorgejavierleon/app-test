<x-landing-layout>
    <div class="h-screen mx-auto max-w-7xl">
        {{--Hero--}}
        <header class="relative flex items-center p-6 bg-right-top bg-no-repeat bg-cover h-1/2"> 
            <div class="text-white align-middle px-14 py-28 max-w-7xl">
                <h1 class="text-4xl md:text-6xl">SE4</h1>
                <h2 class="md:text-lg">Tfhratptemc byu Synolia Mobile</h2>
            </div>
        </header>
        {{--Features--}}
        <section class="px-6 py-16 mx-auto bg-gray-800 md:px-12">
            <h3 class="text-2xl text-white md:text-3xl">Tfhratptemc SE4</h3>
            <p>
                The folding heated, rollable and transparent phone taht even makes
                coffe. Second edition 4
            </p>
            <div class="px-6 py-8 text-center md:px-28">
                <p class="text-sm">
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Reiciendis
                    repellat iusto quaerat esse non, facere architecto, consequatur a
                    sed accusamus saepe illum! Aperiam, porro accusantium recusandae
                    fugiat voluptatum earum ipsam. Lorem ipsum dolor sit amet
                    consectetur adipisicing elit. Modi esse, neque reprehenderit vero
                    eum ut laboriosam rerum, molestias nisi quia sint molestiae nostrum
                    vel culpa numquam porro perferendis repudiandae suscipit. Lorem
                    ipsum dolor sit, amet consectetur adipisicing elit. Doloremque
                    quidem nisi odit itaque autem, dolore qui ratione perspiciatis vel
                    exercitationem similique debitis ullam rerum officiis suscipit
                </p>
            </div>
            <div class="md:px-16">
                <table class="table-auto">
                    <tr class="border-b-2 border-collapse border-gray-300">
                        <td class="w-1/2 py-3">CPU</td>
                        <td class="w-1/2">
                            Synolia Mobile Sylicon S4 <br />
                            <span class="text-sm"
                              >4.5Ghz Quantum Processor, 5 human brain level neural
                              network</span
                            >
                        </td>
                        <td></td>
                    </tr>
                    <tr class="border-b-2 border-collapse border-gray-300">
                        <td class="py-3">RAM</td>
                        <td>8TB of lunar gold memory</td>
                    </tr>
                    <tr class="border-b-2 border-collapse border-gray-300">
                        <td class="w-1/2 py-3">Capacity</td>
                        <td>Unlimited supra cloud (hosted on secured Mars Datacenter)</td>
                    </tr>
                    <tr class="border-b-2 border-collapse border-gray-300">
                        <td class="w-1/2 py-3">Camera</td>
                        <td>3D scanner eyeleved definition & Olfactory Camera</td>
                    </tr>
                    <tr class="border-b-2 border-collapse border-gray-300">
                        <td class="w-1/2 py-3">Connectivity</td>
                        <td>Wifi a,n,z / 15g antenna / Redtooth</td>
                    </tr>
                </table>
            </div>
        </section>
        {{--FORM--}}
        @livewire('landing-subscribers')
    {{--FOOTER--}}
      <section class="px-12 py-16 mx-auto bg-gray-800 h-80"></section>
    </div>
    @push('styles')
        <style>
            header {
              background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                url({{asset('images/transparent-phone2.jpg')}});
            }
        </style>
    @endpush
</x-landing-layout>
