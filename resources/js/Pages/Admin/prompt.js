import { formatDate } from '@fullcalendar/core';
import { calendarOptions, promptContent, formTransformer, addEvent } from './Calendar.vue';

export const prompt = (selectInfo) => {
console.log(calendarOptions.getEvents());
const startStr = formatDate(selectInfo.startStr, { month: 'long', day: 'numeric', timeZoneName: 'short', locale: 'en' });
const endStr = formatDate(selectInfo.endStr, { month: 'long', day: 'numeric', timeZoneName: 'short', locale: 'en' });

alertify.confirm()
.set('labels', { ok: 'Confirm', cancel: 'Cancel' })
.setHeader('Choose a research paper for the indicated date and time of defense')
.setContent(promptContent(papers))
.set('onok', (event, value) => {
const selectedPaperId = document.getElementById('paperSelect').value;
if (selectedPaperId) {
const selectedPaper = papers.find(paper => paper.id === parseInt(selectedPaperId));
console.log('Confirmed! Selected Paper:', selectedPaper.title);
formTransformer(selectInfo, selectedPaperId);
addEvent();
} else {
console.log('No paper selected.');
}
})
.set('oncancel', () => console.log('Cancelled!'))
.show()
.setting({ 'closableByDimmer': true });
};
