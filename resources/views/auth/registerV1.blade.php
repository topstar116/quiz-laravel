<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <div style="font-size: 40px;font-weight: bolder;">新規会員登録</div>
        </x-slot>

        <!-- Validation Errors -->
        <x-validation-errors class="mb-4" :errors="$errors" />

        <form name="Form1" method="POST" action="{{ route('register') }}">
            @csrf

<!--
	    <!--script>
	    function salesflg() {
    		    if ( document.Form1["role"][1].checked ) {
			    document.getElementById("company").disabled = false;
        		    document.getElementById("initName_f").disabled = false;
			    document.getElementById("initName_l").disabled = false;
			    document.getElementById("name").disabled = true;
	            } else {
			    document.getElementById("company").disabled = true;
        		    document.getElementById("initName_f").disabled = true;
			    document.getElementById("initName_l").disabled = true;
			    document.getElementById("name").disabled = false;
    			    }
	    }
	    window.onload = salesflg;
	    </script>
>

	    <!-- role -->
            <div>
	    <input type="radio" name="role" value="recruiment" onClick="salesflg();" checked >採用&nbsp
	    <input type="radio" name="role" value="sales" onClick="salesflg();">営業&nbsp
	    <input type="radio" name="role" value="management" onClick="salesflg();">管理&nbsp
            </div><br>

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('名前')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
            </div><br>

            <!-- CompanyName -->
            <div>
                <x-label for="company" :value="__('会社名 ')" />
                ※紹介企業を入力ください
                <x-input id="company" class="block mb-5 w-full" type="text" name="company" :value="old('company')" required />      
            </div>

            <!-- Initial Name -->
            <div>
                <x-label for="initName_f" :value="__('イニシャル名字')" />
                <x-input id="initName_f" class="block mb-5 w-full" type="text" name="initName_f" :value="old('initName_f')" />
            </div>

            <!-- Initial Name -->
            <div>
                <x-label for="initName_l" :value="__('イニシャル名前')" />
                <x-input id="initName_l" class="block mb-5 w-full" type="text" name="initName_l" :value="old('initName_l')"  required />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('メールアドレス')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('メールアドレス')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('パスワード')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('パスワード確認')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('既に会員登録済み の方は こちら') }}
                </a>

                <x-button class="ml-4">
                    {{ __('同意して登録する') }}
                </x-button>
            </div>

        </form>
    </x-auth-card>
</x-guest-layout>