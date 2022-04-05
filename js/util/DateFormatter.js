class DateFormatter {
    static days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    static months = ['January','February','March','April','May','June','July','August','September','October','November','December'];

    /**
     * Convert date string to day of the week
     * @param {string} _date - The date string in mm-dd-yyyy format (3-11-2022)
     * @param {string} _time - The time string of the day. Defaulted at 12:00 PM
     */

    static date(_date, _time='12:00 PM') {
        let d = new Date(_date + ' ' + _time);
        return `${this.days[d.getDay()]}, ${this.months[d.getMonth()]} ${parseInt(_date.split("-")[2],10)}`;
    }

    /** 
     * Convert 24h time to 12h
     * @param {string} _time - The time in 24h format (13:00:00)
    */

    static time(_time) {
        var tdata = d;
        var h = parseInt(tdata[0]);
        const suffix = h >= 12 ? 'PM' : 'AM';
        h = ((h + 11) % 12 + 1);
        return h + ':' + tdata[1] + ` ${suffix}`;
    }

    /**
     * Convert a full date/time to day of the week and time in 12h format
     * @param {string} datetime - Input string, in the date time format (3-11-2022 13:00:00)
     */

    static tostring(datetime) {
        const dt = datetime.split(' ');
        return `${this.date(dt[0])} ${this.time(dt[1])}`;
    }
}