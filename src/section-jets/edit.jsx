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
  const { link, src, title } = props;
  return (
    <div className="jet-item">
      <img className="jet-item__img" src={src} alt={title} />
      <h2 className="jet-item__title">{title}</h2>
      <a
        className="jet-item__link"
        href={link}
        target="_blank"
        rel="noopener noreferrer"
      >
        Ver Jet Privado
      </a>
    </div>
  );
};
const Edit = props => {
  const { attributes, setAttributes, isSelected } = props;
  // const { post } = attributes;
  const [jets, setJets] = useState(null);

  useEffect(async () => {
    const fetchedJets = await fetchApi({ path: '/wp/v2/abs_jets' });
    console.log(fetchedJets);
    const newJets = fetchedJets.map(jet => {
      const el = document.createElement('div');
      el.innerHTML = jet.content.rendered;
      const imgSrc = el.querySelector('.wp-block-image img').src;
      return {
        id: jet.id,
        title: jet.title.rendered,
        link: jet.link,
        src: imgSrc
      };
    });
    console.log(newJets);
    setJets(newJets);
  }, []);
  const classes = ['section-jets', checkClass(!jets, 'no-data')].join(' ');
  return (
    <div className={classes}>
      {jets ? (
        jets.map((jet, i) => <Jets key={i} {...jet} />)
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
