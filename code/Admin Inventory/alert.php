<link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300&display=swap" rel="stylesheet">

<div class="buttons-container">
  <p class="btn-toast success"
     data-type="success"
     data-icon="check-circle"
     data-message='Success toast with infinite duration - data-duration="0"'
     data-duration="0">success toast</p>

  <p class="btn-toast system"
     data-type="system"
     data-icon="info-circle"
     data-message="System toast with default duration">system toast</p>

  <p class="btn-toast warning"
     data-type="warning"
     data-icon="exclamation-triangle"
     data-message="Warning toast with default duration">warning toast</p>

  <p class="btn-toast error"
     data-type="error"
     data-icon="exclamation-circle"
     data-message='Error toast with custom duration of 5s - data-duration="5000"'
     data-duration="5000">error toast</p>
</div>


<style>


/* :root {
  --white: #fff;
  --green: #4caf50;
  --blue: #2896f3;
  --yellow: #fbc107;
  --red: #f55153;
  --transition-duration: 0.25s;
} */

/* *,
::after,
::before {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

html {
  font-size: 62.5%;
} */

/* body {
  min-height: 100vh;
  padding: 2.4rem;
  background: #121212;
  color: #d6d6d6;
  font-family: 'Work Sans', sans-serif;
} */

h1 {
  text-align: center;
  font-size: clamp(2.4rem, 3vw, 4rem);
}

.buttons-container {
  display: flex;
  align-items: center;
  height: calc(100vh - 10.4rem);
  flex-wrap: wrap;
  justify-content: center;
  padding: 2.4rem;
  
  .btn-toast {
    padding: 0.8rem 1.6rem;
    font-size: 1.6rem;
    transition: filter var(--transition-duration);
    cursor: pointer;
    color: #fff;

    &:not(:last-child) {
      margin-right: 0.8rem;
    }
    &[data-type="success"] {
      background-color: var(--green);
    }
    &[data-type="system"] {
      background-color: var(--blue);
    }
    &[data-type="warning"] {
      background-color: var(--yellow);
    }
    &[data-type="error"] {
      background-color: var(--red);
    }
    &:hover {
      filter: opacity(0.9);
    }
  }
}

// TOASTS CSS
.toasts-container {
  position: fixed;
  top: 0;
  right: 0;
  padding: 2.4rem;
  z-index: 100;

  .toast {
    position: relative;
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 50rem;
    min-width: 28rem;
        background-color: #121212;
    border-radius: 1.2rem;
    padding: 2.4rem;
    margin-bottom: 2.4rem;
    opacity: 0;
    transform: translateX(100%);
    animation: toast-opening var(--transition-duration) ease-in-out forwards;
    // needed to hide progress bar overflow
    overflow-x: hidden;

    &:not(.active) {
      animation-name: toast-closing;
      animation-duration: 0.35s;
    }

    .t-icon {
      margin-right: 2.4rem;

      svg {
        fill: var(--white);
        width: 2.4rem;
        height: 2.4rem;
      }
    }

    .t-message {
      margin-right: 2.4rem;
      color: var(--white);
      line-height: 2rem;
      font-size: clamp(1.2rem, 1.8vw, 1.6rem);
    }

    .t-close {
      svg {
        fill: var(--white);
        opacity: 1;
        width: 1.8rem;
        height: 1.8rem;
        transition: opacity var(--transition-duration);
        cursor: pointer;

        @media (hover: hover) {
          opacity: 0.5;
        }
      }

      &:hover svg {
        opacity: 1;
      }
    }

    .t-progress-bar {
      display: block;
      position: absolute;
      bottom: 0;
      left: 0;
      height: 6px;
      width: 100%;
      border-radius: 0 0 0 0.5rem;
      background-color: rgba(255, 255, 255, 0.5);
      animation: progress-bar-animation linear forwards var(--toast-duration, 3000ms);
      transform-origin: left;
    }

    &.success {
      background-color: var(--green);
    }
    &.system {
      background-color: var(--blue);
    }
    &.warning {
      background-color: var(--yellow);
    }
    &.error {
      background-color: var(--red);
    }
  }
}

@keyframes toast-opening {
  from {
    opacity: 0;
    transform: translateX(100%);
  }
  to {
    opacity: 1;
    transform: translateX(0%);
  }
}

@keyframes toast-closing {
  0% {
    opacity: 1;
    transform: translateX(0%);
  }
  75% {
		max-height: 15rem;
		padding: 2.4rem;
    opacity: 0;
    transform: translateX(100%);
  }
  100% {
		max-height: 0;
		padding: 0;
		transform: translateX(100%);
  }
}

@keyframes progress-bar-animation {
  to {
    transform: scaleX(0);
  }
}

</style>



<Script>

interface SwipeConfig {
  touchstartX: number;
  touchstartY: number;
  touchendX: number;
  touchendY: number;
}

type SwipeType = 'down' | 'up' | 'left' | 'right' | 'tap';

class SwipeHandler {
  getSwipeDirection({ touchstartX, touchstartY, touchendX, touchendY }: SwipeConfig): SwipeType {
    const delx = touchendX - touchstartX;
    const dely = touchendY - touchstartY;

    if (Math.abs(delx) > Math.abs(dely)) {
      return delx > 0 ? 'right' : 'left';
    }
    if (Math.abs(delx) < Math.abs(dely)) {
      return dely > 0 ? 'down' : 'up';
    }

    return 'tap';
  }
}

// TOAST
type ToastType = 'success' | 'system' | 'error' | 'warning';

type IconName = 'check-circle' | 'info-circle' | 'exclamation-circle' | 'exclamation-triangle' | 'x-lg';

interface Icon {
  name: IconName;
  svg: string;
}

interface ToastConfig {
  type: ToastType;
  icon: IconName;
  message: string;
  duration?: number;
}

const svgIcons: Icon[] = [
  {
    name: 'check-circle',
    svg: `
      <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'>
        <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
      </svg>
    `,
  },
  {
    name: 'info-circle',
    svg: `
      <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'>
        <path d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z'/>
      </svg>
    `,
  },
  {
    name: 'exclamation-circle',
    svg: `
      <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'>
        <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z'/>
      </svg>
    `,
  },
  {
    name: 'exclamation-triangle',
    svg: `
      <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'>
        <path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
      </svg>
    `,
  },
  {
    name: 'x-lg',
    svg: `
      <svg xmlns='http://www.w3.org/2000/svg' class='t-close' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'>
        <path d='M1.293 1.293a1 1 0 0 1 1.414 0L8 6.586l5.293-5.293a1 1 0 1 1 1.414 1.414L9.414 8l5.293 5.293a1 1 0 0 1-1.414 1.414L8 9.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L6.586 8 1.293 2.707a1 1 0 0 1 0-1.414z'/>
      </svg>
    `,
  },
];

class ToastsFactory {
  private toastsContainer: HTMLElement;

  constructor(private readonly swipeHandler: SwipeHandler) {
    this.createToastsContainer();
    this.createToastsFromButtons();
  }

  private createToastsContainer(): void {
    const toastsContainer = document.createElement('div');
    toastsContainer.classList.add('toasts-container');
    this.toastsContainer = toastsContainer;
    document.body.appendChild(toastsContainer);
  }

  private createToastsFromButtons(): void {
    document.addEventListener('click', (e: any) => {
      if (!e.target.matches('.btn-toast')) return;

      const dataset = e.target.dataset;
      const config: ToastConfig = {
        type: dataset.type,
        icon: dataset.icon,
        message: dataset.message,
        duration: dataset.duration ? parseInt(dataset.duration, 10) : undefined,
      };
      this.createToast(config);
    }, false);
  }

  createToast({ type, icon, message, duration }: ToastConfig): void {
    const toast = this.createToastContainer(type);
    this.addToastElement(toast, 't-icon', svgIcons.find((item) => item.name === icon).svg);
    this.addToastElement(toast, 't-message', message);
    this.addCloseButton(toast);
    const progressBar = this.getProgressBar(duration);
    progressBar && toast.appendChild(progressBar);

    this.observeSwipe(toast, 'right');

    this.toastsContainer.appendChild(toast);

    if (!progressBar) return;

    progressBar.onanimationend = () => this.removeToast(toast);
  }

  private createToastContainer(type: ToastType): HTMLElement {
    const toast: HTMLElement = document.createElement('div');
    toast.classList.add('toast', type, 'active');
    return toast;
  }

  private addToastElement(toast: HTMLElement, className: string, content: string): HTMLElement {
    const element = document.createElement('div');
    element.classList.add(className);
    element.innerHTML = content;
    toast.appendChild(element);
    return element;
  }

  private addCloseButton(toast: HTMLElement): void {
    const closeButton = this.addToastElement(toast, 't-close', svgIcons.find((icon) => icon.name === 'x-lg').svg);
    closeButton.onclick = () => this.removeToast(toast);
  }

  private getProgressBar(duration?: number): HTMLElement | undefined {
    if (duration === 0) return;

    const progressBar = document.createElement('div');
    progressBar.classList.add('t-progress-bar');
    duration && progressBar.style.setProperty('--toast-duration', `${duration}ms`);
    return progressBar;
  }

  private removeToast(toast: HTMLElement): void {
    toast.classList.remove('active');
    toast.onanimationend = (evt: AnimationEvent) => {
      evt.target === toast && toast.remove();
    };
  }

  private observeSwipe(toast: HTMLElement, direction: Exclude<SwipeType, 'tap'>): void {
    let touchstartX = 0, touchstartY = 0, touchendX = 0, touchendY = 0;

    toast.addEventListener('touchstart', (event) => {
      window.document.body.style.overflow = 'hidden';
      touchstartX = event.changedTouches[0].screenX;
      touchstartY = event.changedTouches[0].screenY;
    }, { passive: true });

    toast.addEventListener('touchend', (event) => {
      window.document.body.style.overflow = 'unset';
      touchendX = event.changedTouches[0].screenX;
      touchendY = event.changedTouches[0].screenY;
      const swipeConfig: SwipeConfig = {
        touchstartX,
        touchstartY,
        touchendX,
        touchendY,
      };

      this.swipeHandler.getSwipeDirection(swipeConfig) === direction && this.removeToast(toast);
    }, { passive: true });
  }
}

const swipeHandler = new SwipeHandler();
const toastsFactory = new ToastsFactory(swipeHandler);

toastsFactory.createToast({
  type: 'system',
  icon: 'info-circle',
  message: 'Check that toast buddy! 🚀',
  duration: 5000,
});

    </Script>