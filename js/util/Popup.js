class Popup {

    /**
     * Displays a green success popup box to the screen
     * @param {string} msg - The message to display 
     */

    static success(msg) {
        alertify.set({ delay: 5000 }); 
        alertify.success(msg);
    }

    /**
     * Displays a red error popup box to the screen
     * @param {string} msg - The message to display
     */

    static error(msg) {
        alertify.set({ delay: 5000 }); 
        alertify.error(msg); 
    }

    /**
     * Displays either a success box or error box depending on the input
     * @param {string} msg - The message to display
     */

    static show(msg) {
        if (msg.indexOf('[Error]')>-1) {
            this.error(msg);
            return;
        }
        this.success(msg);
    }
}