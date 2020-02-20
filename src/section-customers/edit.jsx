import Loader from './../components/Loader/Loader.jsx';
import Aux from './../components/Aux.jsx';

const { __ } = wp.i18n; // Import __() from wp.i18n
const {
  RichText,
  MediaUpload,
  URLInputButton,
  InspectorControls
} = wp.blockEditor;
const {
  RadioControl,
  ColorPicker,
  PanelBody,
  RangeControl,
  TextControl
} = wp.components;
const { parse } = wp.blockSerializationDefaultParser;
const fetchApi = wp.apiFetch;
function checkClass(varible, className) {
  return varible === true && varible !== undefined ? className : '';
}
const { useState, useEffect } = React;
const Customer = props => {
  const { src, title } = props;
  return (
    <button className="section-customer">
      <img src={src} alt={title} />
    </button>
  );
};
const Edit = props => {
  const { attributes, setAttributes, isSelected } = props;
  // const { post } = attributes;
  const [customers, setCustomers] = useState(null);

  useEffect(async () => {
    const fetchedCustomers = await fetchApi({ path: '/wp/v2/abs_customers' });
    const newCustomers = fetchedCustomers.map(({ blocks }) => {
      const data = blocks.find(block => block.blockName === 'asb/customers')
        .attrs;
      // console.log(data);
      return {
        src: data.logo.url,
        title: data.title
      };
    });
    console.log(newCustomers);
    setCustomers(newCustomers);
    // setJets(newJets);
  }, []);
  const classes = ['section-customers', checkClass(!customers, 'no-data')].join(
    ' '
  );
  return (
    <div className={classes}>
      {customers ? (
        customers.map((customer, i) => <Customer key={i} {...customer} />)
      ) : (
        <Aux>
          <h2 className="section-customers__title">{__('Cargando Datos')}</h2>
          <Loader />
        </Aux>
      )}
    </div>
  );
};

export default Edit;
