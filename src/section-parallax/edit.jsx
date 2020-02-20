import Loader from './../components/Loader/Loader.jsx';
import Aux from './../components/AuxComponent.jsx';

const { __ } = wp.i18n; // Import __() from wp.i18n
const {
  RichText,
  MediaUpload,
  URLInputButton,
  InspectorControls,
  BlockControls,
  InnerBlocks
} = wp.blockEditor;
const {
  RadioControl,
  ColorPicker,
  PanelBody,
  RangeControl,
  TextControl,
  Tooltip,
  Toolbar
} = wp.components;
const { withState } = wp.compose;
const { parse } = wp.blockSerializationDefaultParser;
const fetchApi = wp.apiFetch;
function checkClass(varible, className) {
  return varible === true && varible !== undefined ? className : '';
}
const { useState, useEffect } = React;

const Edit = props => {
  const { attributes, setAttributes, isSelected } = props;
  const { image, options } = attributes;
  const { background, borderRadius, main } = options;
  const classes = [
    'section-parallax',
    checkClass(main, 'default-width'),
    checkClass(borderRadius, 'radius'),
    background === 'dark' ? 'dark' : ''
  ].join(' ');
  const setOption = (key, value) => {
    const newOptions = { ...options };
    newOptions[key] = value;
    setAttributes({ options: newOptions });
  };
  console.log(classes);
  return (
    <div
      className={classes}
      style={{ '--url-image': image.id ? `url(${image.url})` : 'transparent' }}
    >
      <InspectorControls>
        <PanelBody title={__('Opciones de la sección')} initialOpen={false}>
          <RadioControl
            label={__('Estilo de fondo')}
            selected={background}
            options={[
              { label: __('Claro'), value: 'light' },
              { label: __('Oscuro'), value: 'dark' }
            ]}
            onChange={value => {
              setOption('background', value);
            }}
          />
          <RadioControl
            label={__('Ancho')}
            selected={main}
            options={[
              { label: __('Ancho completo'), value: false },
              { label: __('Ancho del contenedor'), value: true }
            ]}
            onChange={value => {
              setOption('main', JSON.parse(value));
            }}
          />
          <RadioControl
            label={__('Borde redondeado')}
            selected={borderRadius}
            options={[
              { label: __('No'), value: false },
              { label: __('Si'), value: true }
            ]}
            onChange={value => {
              setOption('borderRadius', JSON.parse(value));
            }}
          />
        </PanelBody>
      </InspectorControls>
      <BlockControls>
        <Tooltip text="Cambiar imagen">
          <MediaUpload
            onSelect={media => {
              const imageData = {
                id: media.id,
                caption: media.name,
                url: media.url
              };
              setAttributes({ image: imageData });
            }}
            title={__('Seleciona una imagen')}
            allowedTypes={['image']}
            value={image.id}
            render={({ open }) => (
              <button onClick={open}>
                <i className="i-image"></i>
              </button>
            )}
          />
        </Tooltip>
      </BlockControls>

      <InnerBlocks />
    </div>
  );
};

export default Edit;
