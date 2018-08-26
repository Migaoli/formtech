import BaseField from './BaseField';
import GenericField from './GenericField';
import MarkdownField from './MarkdownField';
import MediaField from './MediaField';
import PanelField from './PanelField';
import TextField from './TextField';
import SelectField from './SelectField';
import TrixField from './TrixField';


export default {
    install(Vue, options = {}) {
        Vue.component(BaseField.name, BaseField);
        Vue.component(GenericField.name, GenericField);
        Vue.component(MarkdownField.name, MarkdownField);
        Vue.component(MediaField.name, MediaField);
        Vue.component(PanelField.name, PanelField);
        Vue.component(TextField.name, TextField);
        Vue.component(SelectField.name, SelectField);
        Vue.component(TrixField.name, TrixField);
    }
}