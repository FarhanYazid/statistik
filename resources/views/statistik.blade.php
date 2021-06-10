<x-template-layout>
    <div class="bg-gray-800 pt-3">
        <div class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white">
            <h3 class="font-bold pl-2">{{$tittle}}</h3>
        </div>
    </div>
    <div class="table w-full p-2">
        <table class="w-2/5 border">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="p-2 border-r cursor-pointer text-sm font-thin text-gray-500">
                        <div class="flex items-center justify-center">
                            Total Skor
                        </div>
                    </th>
                    <th class="p-2 border-r cursor-pointer text-sm font-thin text-gray-500">
                        <div class="flex items-center justify-center">
                            Skor Maksimal
                        </div>
                    </th>
                    <th class="p-2 border-r cursor-pointer text-sm font-thin text-gray-500">
                        <div class="flex items-center justify-center">
                            Skor Minimal
                        </div>
                    </th>
                    <th class="p-2 border-r cursor-pointer text-sm font-thin text-gray-500">
                        <div class="flex items-center justify-center">
                            Rata-rata
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody class="py-5">
                <tr class="bg-gray-100 text-center border-b text-base text-gray-600">
                    <td class="p-2 border-r">{{$totalskor}}</td>
                    <td class="p-2 border-r">{{ $max }}</td>
                    <td class="p-2 border-r">{{ $min }}</td>
                    <td class="p-2 border-r">{{ $rata2 }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</x-template-layout>