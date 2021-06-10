<x-template-layout>
    <div class="bg-gray-800 pt-3">
        <div class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white">
            <h3 class="font-bold pl-2">{{$tittle}}</h3>
        </div>
    </div>
    <div class="grid grid-cols-12">
        <div class="w-full text-center mt-2 ml-1 col-span-4">
            <form action="{{(isset($data))?route('data.update', $data->id):route('data.store')}}" method="POST">
                @csrf
                @if(isset($data))
                @method('PUT')
                @endif
                <div class="max-w-sm mx-auto p-1 pr-0 flex items-start form-group">
                    <input type="number" name="skor" for="skor" placeholder="Masukkan Skor" value="{{(isset($data))?$data->skor:old('data')}}" class="@error('skor') border-red-500 @enderror focus:outline-none focus:ring focus:border-blue-300 flex-1 appearance-none  rounded shadow p-3 text-grey-dark mr-2 focus:outline-none">
                    <div class="ml-4 text-sm text-left text-red-600">@error('skor') {{$message}} @enderror</div>
                    <div>
                        <button type="submit" class="appearance-none bg-green-800 hover:bg-green-700 text-white focus:outline-none focus:ring focus:border-blue-300  font-thin tracking-wide uppercase p-3 rounded shadow hover:bg-indigo-light">Input</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-template-layout>