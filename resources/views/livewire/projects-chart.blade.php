<div>
    <div class="flex flex-row gap-4" style="height: 300px"> 
        <div class="w-1/3">
           
            {{-- task pie chart --}}
            <div style="height: 300px;"> 
                <flux:heading class="text-center text-xs sm:text-base">Your projects</flux:heading>
                <livewire:livewire-pie-chart key="{{ $pieChartModel->reactiveKey() }}"
                    :pie-chart-model="$pieChartModel" />
            </div>
            
        </div>

        <div class="w-1/3 items-center">
            <flux:heading class="text-center text-xs sm:text-base">Completed</flux:heading>
            <livewire:projects-counter></livewire:projects-counter>
        </div>

        <div class="w-1/3 ">
            <flux:heading class="text-center text-xs sm:text-base">Yet to complete</flux:heading>
            <livewire:total-projects-counter></livewire:total-projects-counter>
        </div>
    </div>
</div>