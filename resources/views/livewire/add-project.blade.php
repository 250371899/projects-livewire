<div>

    {{-- wire form for sending the user input to the component --}}
        <div class="flex flex-col gap-6 w-full ">
        <div>
            {{-- no csrf required --}}
            <flux:field class="flex flex-col">
            <flux:label>Title</flux:label>
            <flux:description>The title to assign to this project</flux:description>
            <flux:input wire:model="title" />    
            {{-- handling validation error message --}}
            @error('title')
                <flux:text class="underline decoration-pink-500/30 text-xs italic">{{ $message }} </flux:text>
            @enderror
            </flux:field>
        </div>
        <div>
            <flux:field class="flex flex-col">
            <flux:label>Description</flux:label>
            <flux:description size="sm">Short description of the project</flux:description>
            <flux:textarea class="resize rounded-md" wire:model='description' />
            {{-- handling validation error message --}}
            @error('description')
                <flux:text class="underline decoration-pink-500/30 text-xs italic">{{ $message }} </flux:text>
            @enderror
  
            </flux:field>    
        </div> 
        <div>
            <flux:field class="flex flex-col">      
            <flux:label>Phase</flux:label>
            <flux:description>Select the phase this project is at</flux:description>
            <div>
            <flux:select wire:model="phase" placeholder="Select a phase">
                <flux:select.option value="0"></flux:select.option>  // added 0 so that if not selected fails
                <flux:select.option value="design">Design</flux:select.option>
                <flux:select.option value="development">Development</flux:select.option>
                <flux:select.option value="testing">Testing</flux:select.option>
                <flux:select.option value="deployment">Deployment</flux:select.option>
                <flux:select.option value="complete">Complete</flux:select.option>
            </flux:select>  
            {{-- handling validation error message --}}
            @error('phase')
                <flux:text class="underline decoration-pink-500/30 text-xs italic">{{ $message }} </flux:text>
            @enderror  
            </div>  
            </flux:field>         
        </div>
        <div>
            <flux:field class="flex flex-col">
            <flux:label>Date</flux:label>
            <flux:description>Planned start date</flux:description>
            <flux:input wire:model="startDate" type="date" max="2999-12-31" />
            {{-- handling validation error message --}}
            @error('startDate')
                <flux:text class="underline decoration-pink-500/30 text-xs italic">{{ $message }} </flux:text>
            @enderror  
            </flux:field>
        </div>
        <div>
            <flux:field class="flex flex-col">
            <flux:label>Date</flux:label>
            <flux:description>Planned end date</flux:description>
            <flux:input wire:model="endDate" type="date" max="2999-12-31" />
            {{-- handling validation error message --}}
            @error('endDate')
                <flux:text class="underline decoration-pink-500/30 text-xs italic">{{ $message }} </flux:text>
            @enderror  
            </flux:field>
        </div>
        <div>
            {{-- submit and reset button --}}
            <flux:button type="submit" wire:click="saveProject" variant="primary" color="green">Add project</flux:button> 
            <flux:button type="button"  wire:click="resetForm" variant="primary" color="grey">Cancel</flux:button>
        </div>
    </div>
</div>
