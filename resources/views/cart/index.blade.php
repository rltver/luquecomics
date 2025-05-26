<x-layouts.app2>
    <div id="cart-products" class="container m-auto max-w-[1500px] px-6 md:px-30 flex flex-col lg:flex-row">

        @include('partials.cartProducts')
    </div>
    @push('scripts')
        <script>
            function assignEventsToCartButtons() {
                document.querySelectorAll('[data-product-id]').forEach(product => {
                    const input = product.querySelector('.quantity');
                    const btnInc = product.querySelector('.increase');
                    const btnDec = product.querySelector('.decrease');
                    const btnDel = product.querySelector('#remove');
                    // const max = parseInt(input.max) || 10;
                    const max = Math.min(parseInt(input.max),10)
                    const min = 1;

                    function updateButtons() {
                        const value = parseInt(input.value);
                        btnDec.disabled = value <= min;
                        btnInc.disabled = value >= max;

                        btnDec.classList.toggle('opacity-50', btnDec.disabled);
                        btnDec.classList.toggle('!cursor-not-allowed', btnDec.disabled);
                        btnInc.classList.toggle('opacity-50', btnInc.disabled);
                        btnInc.classList.toggle('!cursor-not-allowed', btnInc.disabled);
                    }

                    function limitAndUpdate(change = 0) {
                        let value = parseInt(input.value) + change;
                        value = Math.max(min, Math.min(max, value));
                        input.value = value;
                        // console.log("el valor de "+product.id+" es: "+value)
                        updateButtons();
                        update()
                    }

                    const update =()=>{
                        fetch(`{{route('cart.update')}}`,{
                            method:"POST",
                            headers:{
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body:JSON.stringify({
                                id:input.id,
                                type:'update',
                                quantity: input.value
                            })
                        })
                            .then(response=>response.json())
                            .then((data) => {
                                // console.log(data)
                                document.querySelector('#cart-products').innerHTML = data.success
                                assignEventsToCartButtons()
                            })
                            .catch((error) => {
                                console.log(error);
                                console.log("Server error");
                            });
                    }
                    const remove =()=>{
                        fetch(`{{route('cart.update')}}`,{
                            method:"POST",
                            headers:{
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body:JSON.stringify({
                                id:input.id,
                                type:'delete',
                            })
                        })
                            .then(response=>response.json())
                            .then((data) => {
                                console.log(data)
                                document.querySelector('#cart-products').innerHTML = data.success
                                assignEventsToCartButtons()
                            })
                            .catch((error) => {
                                console.log(error);
                                console.log("Server error");
                            });
                    }

                    btnInc.addEventListener('click', () => limitAndUpdate(1));
                    btnDec.addEventListener('click', () => limitAndUpdate(-1));
                    input.addEventListener('change', () => limitAndUpdate(0));
                    btnDel.addEventListener('click', () => remove())
                    // Init
                    updateButtons();


                });
            }
            assignEventsToCartButtons()

        </script>
    @endpush
</x-layouts.app2>
