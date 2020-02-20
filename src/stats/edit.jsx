import Add from './../components/AddIcon.jsx';

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
function checkClass(varible, className) {
  return varible === true && varible !== undefined ? className : '';
}
const Stat = props => {
  return (
    <div className="stat">
      <RichText
        className="stat__number"
        value={props.stat.number}
        onChange={props.changeNumber}
        placeholder={__('Cantidad...')}
      />
      <RichText
        className="stat__text"
        value={props.stat.text}
        onChange={props.changeText}
        placeholder={__('Descripción...')}
      />
      <button className="stat__delete" onClick={props.delete}>
        <Add />
      </button>
    </div>
  );
};
const Edit = props => {
  const { attributes, setAttributes, isSelected } = props;
  const { stats } = attributes;

  const classes = [props.className, 'stats'];
  const statDefault = {
    number: null,
    text: null
  };
  const handleChange = (type, value, index) => {
    const newStast = stats.map((stat, i) => {
      if (index !== i) {
        return stat;
      }
      const newStat = { ...stat };
      newStat[type] = value;
      return newStat;
    });
    setAttributes({ stats: newStast });
  };
  const handleDelete = index => {
    const newStast = stats.filter((stat, i) => (i === index ? false : stat));
    setAttributes({ stats: newStast });
  };
  return (
    <div className={classes.join(' ')}>
      {stats.map((stat, i) => (
        <Stat
          key={i}
          stat={stat}
          changeNumber={value => handleChange('number', value, i)}
          changeText={value => handleChange('text', value, i)}
          delete={() => handleDelete(i)}
        />
      ))}
      <button
        className="stats__add"
        onClick={() => {
          const newStats = [...stats];
          newStats.push(statDefault);
          setAttributes({ stats: newStats });
        }}
      >
        <Add />
      </button>
    </div>
  );
};

export default Edit;
