import React, { useState, useEffect } from "react";

const WaterConsumption = () => {
    const [meters, setMeters] = useState([]);

    const [selectedMeter, setSelectedMeter] = useState("");

    const [selectedMonth, setSelectedMonth] = useState("2026-02");

    const [consumption, setConsumption] = useState(0);

    // 加载所有水表

    useEffect(() => {
        fetch("/api/water_meters")
            .then((res) => res.json())

            .then((data) => setMeters(data["member"] || []));
    }, []);

    // 根据选择的水表和月份查询读数

    useEffect(() => {
        if (selectedMeter) {
            // 获取该水表的所有读数并按时间排序
            fetch(
                `/api/readings?waterMeter.serialNumber=${selectedMeter}&order[createdAt]=desc`
            )
                .then((res) => res.json())
                .then((data) => {
                    const readings = data["member"] || [];

                    // 1. 找到选中月份的最后一次读数
                    const currentMonthReading = readings.find((r) =>
                        r.createdAt.startsWith(selectedMonth)
                    );

                    // 2. 找到选中月份之前的最近一次读数（即上月读数）
                    const previousReadings = readings.filter(
                        (r) => r.createdAt < selectedMonth
                    );
                    const lastMonthReading =
                        previousReadings.length > 0
                            ? previousReadings[0]
                            : null;
                    console.log(
                        currentMonthReading.value,
                        lastMonthReading.value
                    );
                    if (currentMonthReading && lastMonthReading) {
                        setConsumption(
                            currentMonthReading.value - lastMonthReading.value
                        );
                    } else if (currentMonthReading && !lastMonthReading) {
                        // 如果是第一笔数据，没有上月读数，通常按当前读数计或设为0
                        setConsumption(currentMonthReading.value);
                    } else {
                        setConsumption(0);
                    }
                });
        }
    }, [selectedMeter, selectedMonth]);

    return (
        <div className="card p-4 shadow-sm">
            <h4 className="mb-3">水表消费查询</h4>

            <div className="row g-3">
                <div className="col-md-6">
                    <label className="form-label">选择水表</label>

                    <select
                        className="form-select"
                        value={selectedMeter}
                        onChange={(e) => setSelectedMeter(e.target.value)}
                    >
                        <option value="">-- 请选择序列号 --</option>

                        {meters.map((m) => (
                            <option key={m.id} value={m.serialNumber}>
                                {m.serialNumber}
                            </option>
                        ))}
                    </select>
                </div>
            </div>

            <div className="col-md-6">
                <label className="form-label">选择月份</label>

                <input
                    type="month"
                    className="form-select"
                    value={selectedMonth}
                    onChange={(e) => setSelectedMonth(e.target.value)}
                />

                <div className="mt-4 text-center">
                    当前月总消费量
                    <div className="display-4 text-primary">
                        {consumption.toFixed(2)} m³
                    </div>
                </div>
            </div>
        </div>
    );
};

export default WaterConsumption;
