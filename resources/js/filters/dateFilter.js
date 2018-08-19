import moment from "moment";

export default function dateFilter(date, format = 'DD.MM.YY') {
    return moment(date).format(format);
}