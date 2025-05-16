<x-filament::page>
    <div class="max-w-xl mx-auto space-y-6">

        {{-- 標題 --}}
{{--        <h2 class="text-2xl font-bold text-gray-800">預約查詢</h2>--}}

        {{-- 查詢表單 --}}
        <div class="border rounded-lg p-4 shadow-sm">
            <form method="GET" class="space-y-4">
                <x-filament::input name="phone"
                                   label="手機號碼"
                                   placeholder="請輸入手機號碼"
                                   required
                                   value="{{ request('phone') }}"
                                   class="w-full border border-gray-300 rounded-md shadow-sm" />

                <x-filament::input name="booking_code"
                                   label="預約碼（6碼）"
                                   placeholder="請輸入預約碼"
                                   required
                                   value="{{ request('booking_code') }}"
                                   class="w-full border border-gray-300 rounded-md shadow-sm" />

                <x-filament::button type="submit" class="w-full">
                    查詢
                </x-filament::button>
            </form>
        </div>

        {{-- 查詢成功訊息 --}}
        @if (session('success'))
            <div class="text-green-600 font-medium text-center">
                {{ session('success') }}
            </div>
        @endif

        {{-- 查詢結果區塊 --}}
        @if ($booking)
            <div class=" border rounded-lg p-6 shadow space-y-4">
                <h3 class="text-lg font-semibold ">預約資訊</h3>

                <div class="text-sm space-y-1">
                    <p><strong>姓名：</strong>{{ $booking->name }}</p>
                    <p><strong>日期：</strong>{{ $booking->date }}</p>
                    <p><strong>時間：</strong>{{ substr($booking->time, 0, 5) }}</p>
                    <p><strong>人數：</strong>{{ $booking->people_count }}</p>
                    <p><strong>備註：</strong>{{ $booking->note ?? '—' }}</p>
                </div>

                {{-- 修改預約 --}}
                <div class="pt-4 border-t">
                    <h4 class="font-medium  mb-2">修改預約時間</h4>
                    <form wire:submit.prevent="updateBooking" class="space-y-3">
                        <x-filament::input
                                type="date"
                                wire:model.defer="editDate"
                                label="修改日期"
                                required
                                class="w-full" />

                        <x-filament::input.select
                                wire:model.defer="editTime"
                                label="修改時間"
                                required
                                class="w-full">
                            @foreach ([
                                '09:00:00' => '09:00',
                                '13:00:00' => '13:00',
                                '15:00:00' => '15:00',
                            ] as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </x-filament::input.select>

                        <x-filament::button type="submit" color="primary" class="w-full">
                            確認修改時間
                        </x-filament::button>
                    </form>
                </div>

                {{-- 取消預約 --}}
                <div class="pt-4 border-t">
                    <h4 class="font-medium mb-2">取消預約</h4>
                    <form wire:submit.prevent="deleteBooking">
                        <x-filament::button color="danger" type="submit" class="w-full"
                                            onclick="return confirm('確定要取消預約嗎？')">
                            取消預約
                        </x-filament::button>
                    </form>
                </div>
            </div>

        @elseif(request()->filled(['phone', 'booking_code']))
            <div class="text-center text-red-600 font-medium">
                查無符合的預約資料，請確認輸入是否正確。
            </div>
        @endif
    </div>
</x-filament::page>
