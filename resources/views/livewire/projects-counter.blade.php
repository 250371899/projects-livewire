<div 

    x-data="{ 
        completed: 0, 
        target: @entangle('completed'),
        time: 3000, 
        startAnimation() {
            let start = null;
            const step = (timestamp) => {
                if (!start) start = timestamp;
                const progress = Math.min((timestamp - start) / this.time, 1);
                this.completed = Math.floor(progress * this.target);
                
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }
    }"
    x-init="startAnimation()"
>
    
{{-- Display the counter --}}
    <div class="text-center p-6 text-5xl font-extrabold text-green-600 mt-2">
        <span x-text="completed">0</span>
    </div>
</div>
