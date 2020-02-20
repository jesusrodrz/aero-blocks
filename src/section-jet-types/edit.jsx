import Loader from './../components/Loader/Loader.jsx';
import Aux from './../components/AuxComponent.jsx';

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
const Jets = props => {
  const { link, src, name } = props;
  return (
    <a className="jet-type" href={link}>
      <img className="jet-type__img" src={src} alt={name} />
      <div className="jet-type__container">
        <h3 className="jet-type__title">Alquiler de jets {name}</h3>
      </div>
    </a>
  );
};
const Edit = props => {
  const { attributes, setAttributes, isSelected } = props;
  // const { post } = attributes;
  const [terms, setTerms] = useState(null);

  useEffect(async () => {
    const fetchedTaxTerms = await fetchApi({ path: '/wp/v2/abs_types' });

    const newTerms = fetchedTaxTerms.map(term => {
      return {
        name: term.name,
        id: term.id,
        link: term.link,
        src: `${pluginData.path}dist/images/placeholder.jpg`
      };
    });
    setTerms(newTerms);
  }, []);
  useEffect(() => {
    if (terms) {
      const newTerms = terms.map(async term => {
        const fetchedPost = await fetchApi({
          path: `/wp/v2/abs_jets?abs_types=${term.id}&per_page=1`
        });
        const el = document.createElement('div');
        el.innerHTML = fetchedPost[0] ? fetchedPost[0].content.rendered : '';
        const img = el.querySelector('.wp-block-image img');
        const imgSrc = img
          ? img.src
          : `${pluginData.path}dist/images/placeholder.jpg`;
        return { ...term, src: imgSrc };
      });
      Promise.all(newTerms).then(result => {
        setTerms(result);
      });
    }
  }, [terms]);
  const classes = [
    'section-jet-types',
    'section-jets',
    checkClass(!terms, 'no-data')
  ].join(' ');
  return (
    <div className={classes}>
      {terms ? (
        terms.map((jet, i) => <Jets key={i} {...jet} />)
      ) : (
        <Aux>
          <h2 className="section-jets__title">{__('Cargando Datos')}</h2>
          <Loader />
        </Aux>
      )}
    </div>
  );
};

export default Edit;
