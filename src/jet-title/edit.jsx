const { __ } = wp.i18n; // Import __() from wp.i18n
const { RichText } = wp.blockEditor;
function checkClass(varible, className) {
  return varible === true && varible !== undefined ? className : '';
}
const Edit = props => {
  const { attributes, setAttributes } = props;
  const { title, placeholder } = attributes;
  const classes = `${props.className} jet__title`;

  return (
    <RichText
      className={classes}
      value={title}
      allowedFormats={['bold', 'italic']}
      onChange={value => setAttributes({ title: value })}
      placeholder={placeholder}
    />
  );
};

export default Edit;
